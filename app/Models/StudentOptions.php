<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentOptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'has_free_sessions_for_company',
        'has_free_unlimited_sessions',
        'has_gift_sessions',
        'has_recurring_gift_sessions',
        'count_free_sessions',
        'count_gift_sessions',
        'count_recurring_gift_sessions',
        'count_trial_sessions',
        'has_email_notification'
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
