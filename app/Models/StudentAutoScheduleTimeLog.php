<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAutoScheduleTimeLog extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'cause', 'details'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
