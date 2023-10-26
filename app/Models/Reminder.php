<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model_type',
        'date_time',
        'type',
        'note',
        'message_type'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the related model (Appointment) for the reminder.
     */
    public function model()
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }
}
