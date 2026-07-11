<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class QuestionStarted implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(public array $data) {}

    public function broadcastOn(): Channel
    {
        return new Channel('room.' . $this->data['room_code']);
    }

    public function broadcastAs(): string
    {
        return 'QuestionStarted';
    }

    public function broadcastWith(): array
    {
        return $this->data;
    }
}