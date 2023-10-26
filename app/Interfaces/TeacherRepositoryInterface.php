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
    public function createTeacherOptions(int $userId): TeacherOptions;
    public function teacherAllowsTrial(int $teacherId): bool;
    public function teacherCanBeBooked(int $teacherId): bool;
}
