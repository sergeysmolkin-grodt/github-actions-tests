<?php

namespace App\Interfaces;

use App\DataTransferObjects\StudentRemindersOptionsData;
use App\Models\StudentOptions;
use App\Models\StudentRemindersOptions;
use App\Models\User;
use App\Models\UserDetails;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


interface StudentRepositoryInterface
{
    public function update(array $studentData) : bool|null;
    public function getStudent(string $id): Model|Collection|Builder|array|null;
    public function delete(string $id) : bool;
    public function createStudentOptions(int $userId): StudentOptions;
    public function destroyStudentOptions(int $userId): bool;
    public function createStudentRemindersOptions(int $userId): StudentRemindersOptions;
    public function getUserWithStudentOptions(string $id): User|null;

    public function getRemindersOptions(int $userId): ?StudentRemindersOptions;
    public function setRemindersOptions(StudentRemindersOptionsData $data): void;
}
