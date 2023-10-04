<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model_type',
        'date_time',
        'type',
        'note'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
