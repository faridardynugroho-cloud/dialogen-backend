<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'code',
        'status',
        'host_player_id',
        'max_players',
        'category',
        'time_limit',
        'questions_ready',
    ];

    protected $casts = [
        'questions_ready' => 'boolean',
        'max_players'     => 'integer',
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function questions()
    {
        return $this->hasMany(RoomQuestion::class)
            ->orderBy('question_order');
    }
}
