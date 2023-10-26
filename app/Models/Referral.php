<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referral_id',
        'is_gift_sessions_assigned',
        'date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function referralUser(): belongsTo
    {
        return $this->belongsTo(User::class, 'referral_id', 'id');
    }
}
