<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'organizer',
        'level', 
        'result',
        'achievement_date',
        'description',
        'evidence_path', 
        'visibility',
        'verification_status',
        'points',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute()
    {
        return $this->verification_status;
    }

    public function getDateAttribute()
    {
        return $this->achievement_date;
    }
}
