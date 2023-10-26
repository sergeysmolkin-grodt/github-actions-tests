<?php

namespace App\Services;

use App\DataTransferObjects\BecomeTeacherData;
use App\Exceptions\CouldNotBecomeTeacherException;
use App\Http\Filters\General\ByEmail;
use App\Http\Filters\General\ByPhoneNumber;
use App\Http\Filters\Student\ByEmailNotification;
use App\Http\Filters\Teacher\ByDaysOfWeek;
use App\Http\Filters\Teacher\ByGender;
use App\Http\Filters\Teacher\ByTimeOfDay;
use App\Models\User;
use App\Models\UserDetails;
use App\Repositories\UserRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected StudentRepository $studentRepository,
        protected TeacherRepository $teacherRepository,
    ) {}

    protected array $generalFilters = [
        ByEmail::class,
        ByPhoneNumber::class
    ];
    protected array $teacherFilters = [
        ByGender::class,
        ByDaysOfWeek::class,
        ByTimeOfDay::class
    ];
    protected array $studentFilters = [
        ByEmailNotification::class
    ];

    public function getUsers($request)
    {
        if (isset($request->role)) {
            return $this->getUsersByRole($request);
        }

        return $this->getAllUsers();
    }

    protected function getAllUsers()
    {
        $data = User::query()->with('userDetails');
        return $this->applyFilters($data, $this->generalFilters)->get();
    }

    protected function getUsersByRole($request)
    {
        $data = User::role($request->role)->with('userDetails');

        $filters = $this->generalFilters;

        if ($request->role === 'student') {
            $data->with('studentOptions');
            $filters = array_merge($filters, $this->studentFilters);
        }

        if ($request->role === 'teacher') {
            $data->with('teacherOptions');
            $filters = array_merge($filters, $this->teacherFilters);
        }

        return $this->applyFilters($data, $filters)->get();
    }

    protected function applyFilters($query, $filters)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->thenReturn();
    }

    public function becomeTeacher(BecomeTeacherData $teacherData): void
    {
        DB::transaction(function () use ($teacherData) {
            $user = Auth::user();

            if ($user->hasRole('teacher')) {
                throw new CouldNotBecomeTeacherException('User is already a teacher');
            }
            $user->removeRole('student');
            $user->assignRole('teacher');

            $this->updateUserDetails($user->id, $teacherData->gender, $teacherData->birthDate);
            $this->updateTeacherAndStudentOptions($user->id);
        });
    }

    private function updateTeacherAndStudentOptions(int $userId): void
    {
        $this->studentRepository->destroyStudentOptions($userId);
        $this->teacherRepository->createTeacherOptions($userId);
    }

    private function updateUserDetails(int $userId, string $gender, string $birthDate): void
    {
        UserDetails::updateOrCreate(
            ['id' => $userId],
            ['gender' => $gender, 'birth_date' => $birthDate]
        );
    }
}
