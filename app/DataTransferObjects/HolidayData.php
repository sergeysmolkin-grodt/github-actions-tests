<?php

namespace App\DataTransferObjects;

class HolidayData
{
    public function __construct(
        public readonly int $teacher_id,
        public readonly string $date
    ) {
    }

}
