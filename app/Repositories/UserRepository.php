<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Provider;
use App\Models\Subscription;
use App\Models\TeacherOptions;
use App\Models\StudentOptions;
use App\Models\StudentRemindersOptions;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Two\User as SocialiteUser;
use Spatie\Permission\Traits\HasRoles;

class UserRepository implements UserRepositoryInterface
{
    use HasRoles;

    public function __construct(
        private User $userModel,
    ) {}

    public function getUserByEmail(string $email): User|null
    {
        return $this->userModel->where('email',  $email)->first();
    }

    public function getUserByMobile(string $mobile): User|null
    {
        if (empty($userDetails = UserDetails::where('mobile', $mobile)->first())) return null;

        return $userDetails->user;
    }

    public function createUserOrUpdate(array $userData): User
    {
        return $this->userModel->updateOrCreate(
            [
                'email' => $userData['email']
            ],
            [
                'password' => Hash::make($userData['password']),
                'firstname' => $userData['firstname'],
                'lastname' => $userData['lastname']
            ]
        );
    }

    public function createUser(array $userData): User
    {
        return $this->userModel->create([
            'firstname' => $userData['firstname'],
            'lastname' => $userData['lastname'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);
    }

    public function createUserDetails(int $userId, array$userData): UserDetails
    {
        $userDetails = [
            'user_id' => $userId,
            'mobile' => $userData['mobile'],
            'country_code' => $userData['countryCode'],
        ];

        if ($userData['role'] == 'student') {
            $userDetails['age_group'] = $userData['ageGroup'];
        }

        if ($userData['role'] == 'teacher') {
            $userDetails['gender'] = $userData['gender'];
            $userDetails['birth_date'] = $userData['birthDate'];
        }

        return UserDetails::create($userDetails);
    }

    public function getUserOrCreate(SocialiteUser $userData): User|null
    {
        return $this->userModel->firstOrCreate(
            [
                'email' => $userData->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'firstname' => $userData->getName(),
                'lastname' => ' '
            ]
        );
    }

    public function getUserProviderOrCreate(int $userId, string $socialId, string $provider): Provider|null
    {
            return Provider::firstOrCreate(
            [
                'user_id' => $userId,
                'provider_id' => $socialId,
                'provider' => $provider
            ],
        );
    }
    public function updateUserRole(int $userId, string $role): void
    {
        $this->userModel->findOrFail($userId)->assignRole($role);
    }

    public function getRoleByEmail(string $email): Role|null
    {
        return $this->userModel->where('email', $email)
            ->first()
            ->roles()
            ->first();
    }

    public function getActiveUserById(int $id): User|null
    {
        return $this->userModel->where('id', $id)->where('is_active', 1)->first();
    }

    public function getUserActiveSubscription(int $userId): Subscription|null
    {
        return $this->userModel->findOrFail($userId)
                   ->studentSubscription()
                   ->where('is_active', 1)
                   ->first();
    }

    public function updateUser(array $userData, User $user) : void
    {
        $user->update($userData);
    }

    public function updateUserDetails(array $data, UserDetails $userDetails) : void
    {
        $userDetails->update($data);
    }

    public function deleteUser(int $id) : bool
    {
        return $this->userModel->findOrFail($id)->delete();
    }

    public function getUserById(int $id): User
    {
        return $this->userModel->findOrFail($id);
    }

    public function verifyUserPhoneNumber($phoneNumber): void
    {
        $userDetail = UserDetails::where('mobile', $phoneNumber)->first();
        $user = $this->userModel->find($userDetail->user_id);
        $user->is_phone_verified = true;
        $user->save();
    }
}
