<?php

namespace App\Repositories;

use App\Interfaces\TeacherRepositoryInterface;
use App\Models\TeacherOptions;
use App\Models\User;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;


class TeacherRepository implements TeacherRepositoryInterface
{
    use ModelTrait;
    protected User $userModel;
    protected UserRepository $userRepository;

    public function __construct(User $userModel, UserRepository $userRepository)
    {
        $this->userModel = $userModel;
        $this->userRepository = $userRepository;
    }

    public function getTeacher(string $id) : Model | null
    {
        return User::with(['userDetails', 'teacherOptions'])->find($id);
    }

    public function updateTeacher(array $data, User $teacher) : void
    {
        $userData = $this->getFillableDataForModel($data, $teacher);
        $this->userRepository->updateUser($userData, $teacher);

        $userDetails = $this->getFillableDataForModel($data, $teacher->userDetails);
        $this->userRepository->updateUserDetails($userDetails, $teacher->userDetails);

        $teacherOptions = $this->getFillableDataForModel($data, $teacher->teacherOptions);
        $this->updateTeacherOptions($teacherOptions, $teacher->teacherOptions);
    }

    public function updateTeacherOptions(array $data, TeacherOptions $teacherOptions) : void
    {
        $teacherOptions->update($data);
    }

    public function createTeacherOptions(int $userId): TeacherOptions
    {
        return TeacherOptions::create([
            'user_id' => $userId,
        ]);
    }

    public function teacherAllowsTrial(int $teacherId): bool
    {
        $teacherOptions = $this->userModel->findOrFail($teacherId)->teacherOptions;

        if (! empty($teacherOptions) && $teacherOptions->allows_trial) {
            return true;
        }
        return false;
    }

    public function teacherCanBeBooked(int $teacherId): bool
    {
        $teacherOptions = $this->userModel->findOrFail($teacherId)->teacherOptions;

        if (! empty($teacherOptions) && $teacherOptions->can_be_booked) {
            return true;
        }
        return false;
    }
}

