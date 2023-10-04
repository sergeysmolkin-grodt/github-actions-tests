<?php

namespace App\DataTransferObjects;

class BecomeTeacherData
{
    public function __construct(
        public readonly string $gender,
        public readonly string $birthDate,
    ) {
    }
}
