<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Models\Room;

class GameStarted implements ShouldBroadcastNow
{
    public function __construct(
        public Room $room,
        public array $questions = [],
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel("room.{$this->room->code}");
    }

    public function broadcastAs(): string
    {
        return 'GameStarted';
    }

    public function broadcastWith(): array
    {
        return [
            'room_code'  => $this->room->code,
            'category'   => $this->room->category,
            'time_limit' => $this->room->time_limit,
            'questions'  => $this->questions,
        ];
    }
}