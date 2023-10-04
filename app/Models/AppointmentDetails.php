<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'subscription_id',
        'is_free_session',
        'is_gift_session',
        'is_gift_recurring_session',
        'is_auto_schedule_session',
        'auto_complete_time',
        'is_summary_session',
        'is_free_session_for_company',
        'is_free_recurring_session_for_company',
        'zoom_data',
        'is_free_unlimited_session',
        'is_trial_session',
        'subscription_id',
        'is_company_session',
        'is_company_recurring_session'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
