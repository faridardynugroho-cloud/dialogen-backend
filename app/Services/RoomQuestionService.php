<?php

namespace App\Services;

use App\Jobs\GenerateQuestionsJob;
use App\Models\Room;
use App\Models\RoomQuestion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomQuestionService
{
    public function __construct(
        protected QuestionService          $questionService,
        protected QuestionPoolService      $poolService,
        protected QuestionGeneratorService $generator,
    ) {}

    private const MIN_QUESTIONS_PER_ROOM = 10;

    public function createRoomQuestions(Room $room): Collection
    {
        $language = $room->category;

        // Cek dari sumber asli — total soal (fresh+old) cukup buat limit?
        // Kalau nggak cukup sama sekali, baru room dilarang jalan.
        if (!$this->poolService->hasEnoughTotalQuestions($language, self::MIN_QUESTIONS_PER_ROOM)) {

            if ($this->poolService->needGenerate($language)) {
                GenerateQuestionsJob::dispatch(language: $language, target: 100)->onQueue('ai-generation');
            }

            throw new \RuntimeException(
                'Bank soal sedang disiapkan. Tunggu beberapa menit lalu coba lagi.'
            );
        }

        // Soal cukup (fresh+old) — room tetap jalan.
        // Kalau fresh menipis, isi ulang stok fresh di background (non-blocking).
        if ($this->poolService->needGenerate($language)) {
            GenerateQuestionsJob::dispatch(language: $language, target: 100)->onQueue('ai-generation');
        }

        return DB::transaction(function () use ($room) {
            if ($room->questions()->exists()) {
                return $this->getRoomQuestions($room)->pluck('question');
            }

            $questions = $this->questionService->getQuestions($room->category);

            foreach ($questions as $index => $question) {
                RoomQuestion::create([
                    'room_id'        => $room->id,
                    'question_id'    => $question->id,
                    'question_order' => $index + 1,
                ]);
            }

            return $questions;
        });
    }
    // Dipanggil saat Game FINISH
    public function finalizeRoomQuestions(Room $room): void
    {
        $questions = $room->questions()
            ->with('question')
            ->get()
            ->pluck('question')
            ->unique('id');

        $this->questionService->markUsed($questions);
    }

    public function getRoomQuestions(Room $room): Collection
    {
        return $room->questions()
            ->with('question')
            ->get();
    }

    public function deleteRoomQuestions(Room $room): void
    {
        $room->questions()->delete();
    }
}
