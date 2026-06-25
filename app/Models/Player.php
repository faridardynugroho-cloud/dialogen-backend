<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
    'username',
    'room_id',
    'uuid',
    'is_host',
    'score',
    'color_avatar',
    'lobby_position',
    'is_online',
];

protected $casts = [
    'is_host'            => 'boolean', // ← tambah
];

 public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
