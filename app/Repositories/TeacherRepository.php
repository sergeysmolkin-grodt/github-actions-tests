<?php

namespace App\Repositories;

use App\Interfaces\TeacherRepositoryInterface;
use App\Models\TeacherOptions;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class TeacherRepository implements TeacherRepositoryInterface
{
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
        $this->userRepository->updateUser($data, $teacher);
        $this->userRepository->updateUserDetails($data, $teacher->userDetails);
        $this->updateTeacherOptions($data, $teacher->teacherOptions);
    }

    public function updateTeacherOptions(array $data, TeacherOptions $teacherOptions) : void
    {
        $teacherOptions->update($data);
    }
}

