<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\AppointmentDetails;
use App\Models\Subscription;
use App\Models\AvailabilityException;
use App\Models\Availability;
use App\Models\UserDevice;
use App\Repositories\UserRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\Models\User;
use App\Traits\DateTimeTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{

    use DateTimeTrait;

    public function __construct(
        protected UserRepository $userRepository,
        protected StudentRepository $studentRepository,
        protected TeacherRepository $teacherRepository,
    )
    {}

    public function loginStudentValidation(array $requestData): string|User
    {
        // Check if User exists by email
        if (empty($user = $this->userRepository->getUserByEmail($requestData['email']))) {
            return __('User with this email does not exist in the system');
        }

        // Check password if login type is 'NORMAL'
        if ($requestData['loginType'] == 'NORMAL') {
            if (! Hash::check($requestData['password'], $user->password)) {
                return __('User with this password does not exist in the system');
            }
        }

        // Check if exists user is_active
        if (! $user->is_active) {
            return __('Your account has been disabled by administrator please contact to administrator');
        }

        // ToDo: add checking deviceId

        return $user;
    }

    public function registerStudentValidation(array $requestData): string|null
    {
        // Check if User exists by email
        if (! empty($this->userRepository->getUserByEmail($requestData['email']))) {
            return __('Email is already exist');
        }

        // Check if User exists by mobile
        if (! empty($this->userRepository->getUserByMobile($requestData['mobile']))) {
            return __('Mobile number is already registered');
        }

        return null;
    }

    public function createUserData(array $requestData): User|null
    {
        $user = $this->userRepository->createUser($requestData);
        $this->userRepository->createUserDetails($user->id, $requestData);

        if ($requestData['role'] == 'teacher') {
            $this->teacherRepository->createTeacherOptions($user->id);
        }

        if ($requestData['role'] == 'student') {
            $this->studentRepository->createStudentOptions($user->id);
            $this->studentRepository->createStudentRemindersOptions($user->id);
        }

        return $user;
    }

    public function createUserDeviceData(array $requestData, int $userId): ?UserDevice
    {
        try {
            return UserDevice::firstOrCreate(
                [
                    'user_id' => $userId,
                    'device_id' => $requestData['deviceId'],
                    'device_type' => $requestData['deviceType'],
                ],
                [
                    'device_token' => $requestData['deviceToken'],
                    'os_version' => $requestData['OSVersion'],
                    'brand' => $requestData['brand'],
                    'model' => $requestData['model'],
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to create or update user device data', [
                'exception' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
