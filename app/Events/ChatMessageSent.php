<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Room $room,
        public string $username,
        public string $message,
        public string $sentAt,
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('room.' . $this->room->code)];
    }

    public function broadcastAs(): string
    {
        return 'ChatMessageSent';
    }

    public function broadcastWith(): array
    {
        return [
            'username'  => $this->username,
            'message'   => $this->message,
            'sent_at'   => $this->sentAt,
        ];
    }
}