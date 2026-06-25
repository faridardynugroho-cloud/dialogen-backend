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
];

 public function players()
    {
        return $this->hasMany(Player::class);
    }
}
