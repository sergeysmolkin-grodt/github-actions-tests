<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class StudentRemindersOptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'has_email_10_minutes_zoom_data',
        'has_whatsapp_30_minutes',
        'has_whatsapp_5_minutes',
        'has_whatsapp_3_hours',
        'has_ivr_2_5_minutes'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


}
