<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SettingsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Room $room) {}

    public function broadcastOn(): array
    {
        return [new Channel('room.' . $this->room->code)];
    }

    public function broadcastAs(): string
    {
        return 'SettingsUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'category'    => $this->room->category,
            'time_limit'  => $this->room->time_limit,
            'max_players' => $this->room->max_players,
        ];
    }
}