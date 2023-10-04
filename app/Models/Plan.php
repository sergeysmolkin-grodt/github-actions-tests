<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'type', 'count_sessions'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function companySubscription()
    {
        return $this->belongsTo(CompanySubscription::class);
    }
}
