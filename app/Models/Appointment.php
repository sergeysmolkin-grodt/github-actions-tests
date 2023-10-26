<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'teacher_id', 'date', 'from', 'to', 'status', 'cancelled_by'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function appointmentDetails(): HasOne
    {
        return $this->hasOne(AppointmentDetails::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
