<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'result',
        'points',
        'is_active',
    ];
}
