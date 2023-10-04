<?php

namespace App\Repositories;

use App\Interfaces\RatingRepositoryInterface;
use App\Models\Rating;

class RatingRepository implements RatingRepositoryInterface
{
    public function __construct(protected AppointmentRepository $appointmentRepository) {
        //
    }

    public function getTotalRatingsForTeacher(string $id): int|null
    {
        $appointmentIds = $this->appointmentRepository->getTotalAppointmentsIdsForTeacher($id);
        return Rating::whereIn('appointment_id', $appointmentIds)->count();
    }

    public function getAverageRatingForTeacher(string $id): float|null
    {
        $appointmentIds = $this->appointmentRepository->getTotalAppointmentsIdsForTeacher($id);
        return Rating::whereIn('appointment_id', $appointmentIds)->avg('rating');
    }
}
