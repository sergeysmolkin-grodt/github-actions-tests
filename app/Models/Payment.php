<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'model_id', 'model_type', 'payment_method', 'payment_date', 'amount', 'status'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
