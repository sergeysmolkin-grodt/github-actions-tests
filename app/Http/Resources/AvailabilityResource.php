<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'is_available' => $this->is_available,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,
            'break_from_time' => $this->break_from_time,
            'break_to_time' => $this->break_to_time,
        ];
    }
}

