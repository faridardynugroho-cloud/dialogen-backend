<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'language',
        'question',
        'options',
        'correct_option',
        'keywords',
        'usage_count',
    ];

    protected $casts = [
        'options' => 'array',
        'keywords' => 'array',
    ];

    public function roomQuestions()
    {
        return $this->hasMany(RoomQuestion::class);
    }
}
