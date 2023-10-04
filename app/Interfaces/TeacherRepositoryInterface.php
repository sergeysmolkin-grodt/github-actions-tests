<?php

namespace App\Interfaces;

use App\Models\TeacherOptions;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface TeacherRepositoryInterface
{
    public function getTeacher(string $id): Model | null;
    public function updateTeacher(array $data, User $teacher) : void;
    public function updateTeacherOptions(array $data, TeacherOptions $teacherOptions) : void;
}
