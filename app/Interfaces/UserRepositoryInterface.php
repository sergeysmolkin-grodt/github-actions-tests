<?php

namespace App\Interfaces;

use App\Models\StudentOptions;
use App\Models\StudentRemindersOptions;
use App\Models\Subscription;
use App\Models\TeacherOptions;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Two\User as SocialiteUser;
use App\Models\Provider;

interface UserRepositoryInterface
{
    public function getUserByEmail(string $email): User|null;
    public function createUserOrUpdate(array $userData): User;
    public function getUserOrCreate(SocialiteUser $userData): User|null;
    public function updateUserRole(int $userId, string $role): void;
    public function getRoleByEmail(string $email): Role|null;
    public function getUserProviderOrCreate(int $userId, string $socialId, string $provider): Provider|null;
    public function getUserActiveSubscription(int $userId): Subscription|null;
    public function createUserDetails(int $userId, array$userData): UserDetails;
    public function updateUser(array $userData, User $user) : void;
    public function updateUserDetails(array $data, UserDetails $userDetails) : void;
    public function deleteUser(int $id) : bool;
}
