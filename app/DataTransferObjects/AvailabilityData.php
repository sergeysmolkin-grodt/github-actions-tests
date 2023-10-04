<?php

namespace App\DataTransferObjects;

class AvailabilityData
{
    public function __construct(
        public readonly int $teacher_id,
        public readonly string|null $from_time,
        public readonly string|null $to_time,
        public readonly string|null $break_from_time,
        public readonly string|null $break_to_time,
        public readonly ?int $id = null,
        public readonly ?string $day = null,
        public readonly ?bool $is_available = null,
        public readonly ?bool $force_change = null,
        public readonly ?string $date = null
    ) {
    }

}
