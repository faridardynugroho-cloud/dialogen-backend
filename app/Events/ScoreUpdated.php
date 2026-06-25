<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Models\Room;

class ScoreUpdated implements ShouldBroadcastNow
{
    public function __construct(
        public Room  $room,
        public array $scores,
        public int   $questionNumber,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel("room.{$this->room->code}");
    }

    public function broadcastAs(): string
    {
        return 'ScoreUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'scores'          => $this->scores,
            'question_number' => $this->questionNumber,
        ];
    }
}