<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class PlayerKicked implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(
        public Room $room,
        public array $allPlayers,
        public int $kickedPlayerId,
        public string $kickedUsername,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('room.' . $this->room->code);
    }

    public function broadcastAs(): string
    {
        return 'PlayerKicked';
    }

    public function broadcastWith(): array
    {
        return [
            'all_players'      => $this->allPlayers,
            'kicked_player_id' => $this->kickedPlayerId,
            'kicked_username'  => $this->kickedUsername,
        ];
    }
}