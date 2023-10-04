<?php

namespace App\Services;

use App\DataTransferObjects\AvailabilityData;
use App\Http\Resources\AvailabilityResource;
use App\Repositories\AppointmentRepository;
use App\Repositories\AvailabilityRepository;
use Illuminate\Support\Facades\Auth;

class AvailabilityService
{
    public function __construct(
        protected AppointmentService $appointmentService,
        protected AvailabilityRepository $availabilityRepository,
        protected AppointmentRepository $appointmentRepository
    ) {}
    /**
     * @param int $teacherId
     * @return array
     */
    public function getFormattedAvailabilityForTeacher(int $teacherId): array
    {
        $availabilities = $this->availabilityRepository->getAvailabilityByTeacherId($teacherId);

        if (empty($availabilities)) {
            return [];
        }

        $formattedData = [];

        foreach ($availabilities as $availability) {
            $formattedData[$availability->day] = new AvailabilityResource($availability);
        }

        return $formattedData;
    }

    /**
     * @param AvailabilityData $availability
     * @return void
     */
    public function changeAvailability(AvailabilityData $availability): void
    {
        if (empty($availability->from_time) || empty($availability->to_time)) {
            return;
        }

        $this->availabilityRepository->updateOrCreate($availability);

        if (!$availability->force_change) {
            return;
        }

        $appointments = $this->appointmentRepository->getUpcomingAppointmentsForTeacherByDayOfWeek(
            $availability->teacher_id,
            config("app.day_of_week_number.$availability->day")
        );

        $currentAdmin = Auth::user();
        $cancelledBy = "$currentAdmin->firstname $currentAdmin->lastname";

        foreach ($appointments as $appointment) {
            $this->appointmentService->checkAppointmentWithAvailability($appointment, $cancelledBy, $availability);
        }
    }
}
