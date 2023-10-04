<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherOptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'introduction_video',
        'attainment',
        'allows_trial',
        'can_be_booked',
        'is_teacher_for_business',
        'is_teacher_for_children',
        'is_teacher_for_beginner',
        'verification_status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
