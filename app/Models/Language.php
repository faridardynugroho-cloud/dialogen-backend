<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'code',
        'name',
        'style_file',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static array $cache = [];

    public static function resolve(string $name): self
    {
        return static::$cache[$name] ??= static::where('name', $name)->firstOrFail();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function questionPool()
    {
        return $this->hasOne(QuestionPool::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
