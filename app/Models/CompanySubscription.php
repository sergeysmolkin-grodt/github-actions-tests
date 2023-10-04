<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class CompanySubscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plan_id', 'company_id', 'type', 'is_active', 'is_pause', 'start_date', 'end_date', 'count_used_sessions'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function plan(): HasOne
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id' );
    }
}
