<?php

namespace App\Events;

use App\Models\Player;
use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerLeft implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Room $room,
        public array $allPlayers,
        public ?int $newHostId   // null kalau room kosong / bukan host yang leave
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('room.' . $this->room->code)];
    }

    public function broadcastAs(): string
    {
        return 'PlayerLeft';
    }

    public function broadcastWith(): array
    {
        return [
            'all_players' => $this->allPlayers,
            'new_host_id' => $this->newHostId,
        ];
    }
}