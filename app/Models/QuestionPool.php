<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionPool extends Model
{
    protected $fillable = [
        'language',
        'total_questions',
        'fresh_questions',
        'is_generating',
        'last_generated',
    ];

    protected $casts = [
        'last_generated' => 'datetime',
        'is_generating' => 'boolean',
    ];
}
