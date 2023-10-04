<?php

namespace App\Interfaces;

use App\Models\StudentAutoScheduleTime;
use App\Models\StudentAutoScheduleTimeLog;
use App\Models\StudentOptions;
use App\Models\Subscription;
use App\Models\TeacherOptions;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Two\User as SocialiteUser;
use App\Models\Provider;

interface AutoScheduleRepositoryInterface
{
    public function create(...$data): StudentAutoScheduleTime|string;
    public function remove(int $studentId): string|null;
    public function log(int $userId, string $cause, string $details): StudentAutoScheduleTimeLog|string|null;
    public function getStudentAutoSchedule(int $studentId): Collection|null;
    public function getIntersections(object $timeDetails): int|null;
    public function getAutoScheduleTimesForProcessing(): Collection;
    public function resetAutoScheduleBookingExpiry(int $teacherId, int $studentId): void;
}
