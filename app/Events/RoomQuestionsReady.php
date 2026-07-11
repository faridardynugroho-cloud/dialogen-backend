<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RoomQuestionsReady implements ShouldBroadcast
{
    public function __construct(public Room $room) {}

    public function broadcastOn(): Channel
    {
        return new Channel('room.' . $this->room->code);
    }

    public function broadcastAs(): string
    {
        return 'RoomQuestionsReady';
    }

    public function broadcastWith(): array
    {
        return ['room_code' => $this->room->code];
    }
}