<?php

namespace App\Jobs;

use App\Models\Room;
use App\Events\SettingsUpdated;
use App\Services\RoomQuestionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateRoomQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 5;

    public function __construct(public Room $room) {}

    public function handle(RoomQuestionService $service): void
    {
        Log::info("Job mulai untuk room: {$this->room->code}");

        if ($service->getRoomQuestions($this->room)->isNotEmpty()) {
            Log::info("Soal sudah ada, skip generate");
            $this->broadcastReady($service);
            return;
        }

        $service->createRoomQuestions($this->room);

        $this->room->update(['questions_ready' => true]);

        Log::info("Soal berhasil dibuat untuk room: {$this->room->code}");

        $this->broadcastReady($service);
    }

    private function broadcastReady(RoomQuestionService $service): void
    {
        $room = $this->room->fresh();

        $questions = $this->formatQuestions($service->getRoomQuestions($room));

        // Broadcast SettingsUpdated fase 2 — dengan soal
        broadcast(new SettingsUpdated($room, $questions));

        Log::info("SettingsUpdated (with questions) broadcast: {$room->code}");
    }

    private function formatQuestions($roomQuestions): array
    {
        return $roomQuestions
            ->sortBy('question_order')
            ->values()
            ->map(fn($rq) => [
                'order'          => $rq->question_order,
                'question'       => $rq->question->question,
                'options'        => $rq->question->options,
                'correct_option' => $rq->question->correct_option,
            ])
            ->toArray();
    }

    public function failed(\Throwable $e): void
    {
        Log::error("GenerateRoomQuestionsJob failed [{$this->room->code}]: " . $e->getMessage());
    }
}