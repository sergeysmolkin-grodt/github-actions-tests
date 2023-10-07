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
}

