<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'rating',
        'comment',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
