<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'student_number',
        'class_name',
        'profile_photo',
        'profile_visibility',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
    public function isAdmin(): bool
    {
        return str_contains(strtolower($this->role ?? ''), 'admin');
    }
}