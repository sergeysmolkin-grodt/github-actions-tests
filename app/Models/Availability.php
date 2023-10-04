<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $table = 'availability';

    protected $fillable = ['teacher_id', 'day', 'is_available', 'from_time', 'to_time', 'break_from_time', 'break_to_time'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
