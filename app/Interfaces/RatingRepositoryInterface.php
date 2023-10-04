<?php

namespace App\Interfaces;

interface RatingRepositoryInterface
{
    public function getTotalRatingsForTeacher(string $id): int|null;
    public function getAverageRatingForTeacher(string $id): float|null;
}
