<?php

namespace App\Events;

use App\Models\Player;
use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerJoined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Room $room,
        public Player $player,
        public array $allPlayers  // semua player di room saat ini
    ) {}

    // Channel yang digunakan: room.{kode_room}
    // Semua client yang subscribe ke channel ini akan terima event
    public function broadcastOn(): array
    {
        return [
            new Channel('room.' . $this->room->code),
        ];
    }

    // Nama event yang diterima Flutter
    public function broadcastAs(): string
    {
        return 'PlayerJoined';
    }

    // Data yang dikirim ke Flutter
    public function broadcastWith(): array
    {
        return [
            'room_code'  => $this->room->code,
            'player' => [
                'id'       => $this->player->id,
                'username' => $this->player->username,
                'is_host'  => $this->player->is_host,
            ],
            'all_players' => $this->allPlayers,
            'total'       => count($this->allPlayers),
        ];
    }
}