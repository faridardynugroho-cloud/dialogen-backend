<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';
    protected $fillable = [
        'type',
        'title',
        'message',
        'email',
        'app_version',
        'app_build',
        'platform',
        'status',
        'admin_notes',
        'ip_address',
    ];

    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }

    public function scopeBugs($query)
    {
        return $query->where('type', 'bug');
    }
}
