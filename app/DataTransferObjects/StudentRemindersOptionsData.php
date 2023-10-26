<?php

namespace App\DataTransferObjects;

class StudentRemindersOptionsData
{
    public function __construct(
        public readonly int $user_id,
        public readonly bool $has_email_10_minutes_zoom_data,
        public readonly bool $has_whatsapp_30_minutes,
        public readonly bool $has_whatsapp_5_minutes,
        public readonly bool $has_whatsapp_3_hours,
        public readonly bool $has_ivr_2_5_minutes,
    ) {
    }
}
