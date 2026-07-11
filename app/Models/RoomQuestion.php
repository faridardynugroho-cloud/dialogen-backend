<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomQuestion extends Model
{
    protected $fillable = [
        'room_id',
        'question_id',
        'question_order',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}