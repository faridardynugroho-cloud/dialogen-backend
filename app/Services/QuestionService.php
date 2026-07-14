<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Collection;

class QuestionService
{
    private const USAGE_THRESHOLD = 2;
    private const DEFAULT_LIMIT   = 10;

    public function __construct(
        protected QuestionPoolService $poolService,
        protected QuestionSelector    $selector,
    ) {}

    // ─────────────────────────────────────────
    // Public API
    // ─────────────────────────────────────────

    public function getQuestions(string $language, int $limit = self::DEFAULT_LIMIT): Collection
    {
        $candidateLimit = $limit * QuestionSelector::CANDIDATE_MULTIPLIER;

        $fresh = $this->pickFreshQuestions($language, $candidateLimit);

        // Gabungkan fresh + old dalam satu pool kandidat
        // Old hanya diambil kalau fresh < candidateLimit
        if ($fresh->count() < $candidateLimit) {
            $needed = $candidateLimit - $fresh->count();
            $old = $this->pickOldQuestions($language, $needed, $fresh->pluck('id'));
            $candidates = $fresh->merge($old);
        } else {
            $candidates = $fresh;
        }

        logger()->info("Candidate = " . $candidates->count());

        // Selector cukup dipanggil SEKALI — tracker konsisten untuk semua kandidat
        $selected = $this->selector->select($candidates, $limit);

        logger()->info("Selected = " . $selected->count());

        return $selected->shuffle();
    }

    public function markUsed(Collection $questions): void
    {
        if ($questions->isEmpty()) {
            return;
        }

        $ids = $questions->pluck('id');

        // Query 1: naikkan semua usage_count sekaligus
        Question::whereIn('id', $ids)->increment('usage_count');

        // Cari soal yang tepat melewati threshold setelah increment
        // Yaitu soal yang usage_count sebelumnya = USAGE_THRESHOLD - 1
        // Sekarang sudah menjadi USAGE_THRESHOLD
        $crossedThreshold = $questions->filter(
            fn(Question $q) => $q->usage_count === self::USAGE_THRESHOLD - 1
        );

        $crossedCount = $crossedThreshold->count();

        if ($crossedCount === 0) {
            return;
        }

        // Query 2: update fresh_questions
        $language = $questions->first()->language;
        $this->poolService->decreaseFreshBy($language, $crossedCount);
    }

    // ─────────────────────────────────────────
    // Internal
    // ─────────────────────────────────────────

    private function pickFreshQuestions(
        string $language,
        int $limit
    ): Collection {

        return Question::where('language', $language)
            ->where('usage_count', '<', self::USAGE_THRESHOLD)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    private function pickOldQuestions(
        string $language,
        int $limit,
        Collection $excludeIds = new Collection()
    ): Collection {

        return Question::where('language', $language)
            ->where('usage_count', '>=', self::USAGE_THRESHOLD)
            ->whereNotIn('id', $excludeIds)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
