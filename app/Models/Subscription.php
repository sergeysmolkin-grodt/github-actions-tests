<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\hasManyThrough;


class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'is_active',
        'type',
        'is_paused',
        'start_date',
        'end_date',
        'paypal_subscription_id',
        'renewal_count'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function plan(): belongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function appointments(): hasManyThrough
    {
        return $this->hasManyThrough(Appointment::class, AppointmentDetails::class, 'subscription_id', 'id', 'id', 'appointment_id');
    }
}
