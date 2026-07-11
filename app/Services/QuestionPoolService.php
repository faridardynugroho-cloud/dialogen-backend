<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionPool;

class QuestionPoolService
{
    private function getPool(string $language): QuestionPool
    {
        return QuestionPool::firstOrCreate(
            ['language' => $language],
            [
                'total_questions' => 0,
                'used_questions' => 0,
                'fresh_questions' => 0,
                'is_generating' => false,
            ]
        );
    }

    public function needGenerate(string $language): bool
    {
        $pool = $this->getPool($language);

        if ($pool->is_generating) {
            return false;
        }

        // Hitung fresh count langsung dari sumber asli, jangan andalkan cache
        $actualFresh = \App\Models\Question::where('language', $language)
            ->where('usage_count', '<', 2)
            ->count();

        if ($actualFresh >= 10) {
            // Sinkronkan cache biar konsisten lagi ke depannya
            $pool->update(['fresh_questions' => $actualFresh]);
            return false;
        }

        $updated = QuestionPool::where('id', $pool->id)
            ->where('is_generating', false)
            ->update(['is_generating' => true]);

        return $updated === 1;
    }

    public function markGenerating(string $language): void
    {
        $pool = $this->getPool($language);

        $pool->update([
            'is_generating' => true
        ]);
    }

    public function markFinished(string $language): void
    {
        $pool = $this->getPool($language);

        $pool->update([
            'is_generating' => false
        ]);
    }

    public function increaseQuestions(
        string $language,
        int $count
    ): void {

        $pool = $this->getPool($language);

        $pool->increment('total_questions', $count);
        $pool->increment('fresh_questions', $count);
    }

    public function increaseUsage(string $language): void
    {
        $pool = $this->getPool($language);

        $pool->increment('used_questions');
    }

    public function decreaseFresh(string $language): void
    {
        $pool = $this->getPool($language);

        if ($pool->fresh_questions > 0) {
            $pool->decrement('fresh_questions');
        }
    }

    // QuestionPoolService
    public function hasEnoughQuestions(string $language, int $needed): bool
    {
        return $this->getPool($language)->fresh_questions >= $needed;
    }

    public function hasEnoughTotalQuestions(string $language, int $needed): bool
    {
        return Question::where('language', $language)->count() >= $needed;
    }

    public function increaseUsageBy(string $language, int $count): void
    {
        $pool = $this->getPool($language);
        $pool->increment('used_questions', $count);
    }

    public function decreaseFreshBy(string $language, int $count): void
    {
        $pool = $this->getPool($language);

        // Jangan sampai fresh_questions turun ke bawah 0
        $actual = min($count, $pool->fresh_questions);

        if ($actual > 0) {
            $pool->decrement('fresh_questions', $actual);
        }
    }
}
