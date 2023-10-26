<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentRemindersOptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'has_email_10_minutes_zoom_data' => $this->has_email_10_minutes_zoom_data,
            'has_whatsapp_30_minutes' => $this->has_whatsapp_30_minutes,
            'has_whatsapp_5_minutes' => $this->has_whatsapp_5_minutes,
            'has_whatsapp_3_hours' => $this->has_whatsapp_3_hours,
            'has_ivr_2_5_minutes' => $this->has_ivr_2_5_minutes
        ];
    }
}
