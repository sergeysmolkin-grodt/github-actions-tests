<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAutoScheduleTime extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'teacher_id', 'day', 'time', 'scheduled_date', 'auto_schedule_booking_expiry'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'student_id', 'user_id')
            ->where('is_active', true);
    }
}
