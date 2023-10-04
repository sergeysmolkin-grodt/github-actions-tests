<?php

namespace App\Interfaces;

use Illuminate\Support\Collection as SupportCollection;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;

interface AppointmentRepositoryInterface
{
    public function findAppointment(int $id): ?Appointment;
    public function deleteAppointment(Appointment $id): int;
    public function deleteAppointmentDetails(Appointment $id): int;
    public function getUpcomingAutoScheduledStudentAppointments(int $studentId): Collection;
    public function update(Appointment $appointment, array $data): int;
    public function getDateTeacherSubscribers(int $teacherId, string $date): Collection;
    public function getTotalCompletedSessionsForTeacher(int $id): int|null;
    public function getTotalAppointmentsIdsForTeacher(int $id): SupportCollection|null;
    public function getUpcomingAppointmentsForTeacherByDayOfWeek(int $teacherId, int $dayOfWeek): Collection|null;
    public function getAppointmentsForTeacherByDate(int $teacherId, string $date): Collection|null;
}
