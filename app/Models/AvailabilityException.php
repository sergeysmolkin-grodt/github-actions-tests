<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilityException extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'date', 'from_time', 'to_time', 'type'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
