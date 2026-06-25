<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Room;

class PlayerOffline implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Room   $room,
        public string $username,
        public array  $allPlayers,
        public ?int   $newHostId,
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel("room.{$this->room->code}")];
    }

    public function broadcastAs(): string
    {
        return 'PlayerOffline';
    }

    public function broadcastWith(): array
    {
        return [
            'username'    => $this->username,
            'all_players' => $this->allPlayers,
            'new_host_id' => $this->newHostId,
        ];
    }
}