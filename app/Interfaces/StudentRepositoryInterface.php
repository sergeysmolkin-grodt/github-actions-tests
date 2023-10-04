<?php

namespace App\Interfaces;

use App\Models\StudentOptions;
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

}
