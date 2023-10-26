<?php

namespace Tests\Integration\Repositories;

use App\Models\Plan;
use App\Models\Provider;
use App\Models\StudentOptions;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserDetails;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;


final class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected UserRepository $userRepository;

    protected Collection $users;
    protected User $detailedUser;

    #[Before]
    public function setUp() : void
    {
        parent::setUp();

        $this->users = User::factory(10)->create([
            'email_verified_at' => '2023-09-17', 'deleted_at' => null
        ]);

        $this->detailedUser = User::factory()->create([
            'email_verified_at' => '2023-09-17', 'deleted_at' => null
        ]);

        $this->detailedUser->userDetails()->create([
            'user_id' => $this->detailedUser->id,
            'mobile' => $this->faker()->phoneNumber()
        ]);

        StudentOptions::factory()->create([
            'user_id' => $this->detailedUser->id,
        ]);

        $this->userRepository = new UserRepository(new User());
    }

    #[Test]
    public function testGetUserByEmailSuccessfully()
    {
        $userToFind = Arr::random($this->users->toArray());

        $result = $this->userRepository->getUserByEmail((string)$userToFind['email']);

        self::assertEquals($result->toArray(), $userToFind);
    }

    #[Test]
    public function testGetUserByEmailReturnsNullIfNotFound()
    {
        $email = 'nonexistent@example.com';

        $result = $this->userRepository->getUserByEmail($email);

        $this->assertNull($result);
    }

    #[Test]
    public function testGetUserByEmailReturnsUserInstance()
    {
        $userToFind = Arr::random($this->users->toArray());

        $user = $this->userRepository->getUserByEmail((string)$userToFind['email']);

        $this->assertInstanceOf(User::class, $user);
    }

    #[Test]
    public function testGetUserByMobileSuccessfully()
    {
        $result = $this->userRepository->getUserByMobile(implode(',', $this->detailedUser->userDetails()->pluck('mobile')->toArray()));

        self::assertEquals($result->toArray(), $this->detailedUser->toArray());
    }

    #[Test]
    public function testGetUserByMobileReturnsNullIfNotFound()
    {
        $mobile = '1234567890test';

        $user = $this->userRepository->getUserByMobile($mobile);

        $this->assertNull($user);
    }

    #[Test]
    public function testGetUserByMobileReturnsUserInstance()
    {
        $user = $this->userRepository->getUserByMobile(implode(',', $this->detailedUser->userDetails()->pluck('mobile')->toArray()));

        $this->assertInstanceOf(User::class, $user);
    }

    #[Test]
    public function testCreateUserOrUpdateActuallyCreatesNewUserIfNotExists()
    {
        $userData = [
            'email' => $this->faker->email,
            'password' => 'password123',
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName
        ];

        $user = $this->userRepository->createUserOrUpdate($userData);

        $this->assertInstanceOf(User::class, $user);

        $this->assertTrue($user->wasRecentlyCreated);

        $this->assertEquals($userData['email'], $user->email);
        $this->assertTrue(Hash::check($userData['password'], $user->password));
        $this->assertEquals($userData['firstname'], $user->firstname);

        $this->assertDatabaseHas('users',array_merge($userData, ['password' => $user->password]));
    }

    #[Test]
    public function testCreateUserOrUpdateActuallyUpdatesExistingUser()
    {

        $updatedUserData = [
            'email' => $this->detailedUser->email,
            'password' => 'new_password',
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName
        ];

        $user = $this->userRepository->createUserOrUpdate($updatedUserData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertFalse($user->wasRecentlyCreated);

        $this->assertEquals($updatedUserData['email'], $user->email);
        $this->assertTrue(Hash::check($updatedUserData['password'], $user->password));
        $this->assertEquals($updatedUserData['firstname'], $user->firstname);

        $this->assertDatabaseHas('users', [
            'email' => $updatedUserData['email'],
            'firstname' => $updatedUserData['firstname'],
            'lastname' => $updatedUserData['lastname']
        ]);

    }

    #[Test]
    public function testCreateUserSuccessfully()
    {

        $userData = [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'password123',
        ];

        $user = $this->userRepository->createUser($userData);

        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals($userData['firstname'], $user->firstname);
        $this->assertEquals($userData['lastname'], $user->lastname);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertTrue(Hash::check($userData['password'], $user->password));

        $this->assertDatabaseHas('users',array_merge($userData, ['password' => $user->password]));
    }

    #[Test]
    public function testCreateUserDetailsForStudentSuccessfully()
    {

        $user = Arr::random($this->users->toArray());

        $userDetailsData = [
            'mobile' => $this->faker->phoneNumber(),
            'countryCode' => $this->faker->countryCode(),
            'role' => 'student',
            'ageGroup' => 'teen',
        ];

        $userDetails = $this->userRepository->createUserDetails($user['id'], $userDetailsData);

        $this->assertInstanceOf(UserDetails::class, $userDetails);

        $this->assertEquals($user['id'], $userDetails->user_id);
        $this->assertEquals($userDetailsData['mobile'], $userDetails->mobile);
        $this->assertEquals($userDetailsData['countryCode'], $userDetails->country_code);
        $this->assertEquals($userDetailsData['ageGroup'], $userDetails->age_group);

        $this->assertDatabaseHas('user_details',$userDetails->toArray());

    }

    #[Test]
    public function testCreateUserDetailsForTeacherSuccessfully()
    {
        $user = Arr::random($this->users->toArray());

        $userData = [
            'mobile' => $this->faker->phoneNumber(),
            'countryCode' => $this->faker->countryCode(),
            'role' => 'teacher',
            'gender' => 'female',
            'birthDate' => $this->faker->date('Y-m-d'),
        ];

        $userDetails = $this->userRepository->createUserDetails($user['id'], $userData);

        $this->assertInstanceOf(UserDetails::class, $userDetails);

        $this->assertEquals($user['id'], $userDetails->user_id);
        $this->assertEquals($userData['mobile'], $userDetails->mobile);
        $this->assertEquals($userData['countryCode'], $userDetails->country_code);
        $this->assertEquals($userData['gender'], $userDetails->gender);
        $this->assertEquals($userData['birthDate'], $userDetails->birth_date);

        $this->assertDatabaseHas('user_details',$userDetails->toArray());
    }


    #[Test]
    public function testGetUserOrCreateActuallyCreatesNewUser()
    {

        $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
        $socialiteUser->shouldReceive('getId')
                      ->andReturn(124)
                      ->shouldReceive('getName')
                      ->andReturn('Test')
                      ->shouldReceive('getEmail')
                      ->andReturn('test@leasoft.org');


        $resultUser = $this->userRepository->getUserOrCreate($socialiteUser);

        $this->assertInstanceOf(User::class, $resultUser);

        $this->assertEquals($socialiteUser->getEmail(), $resultUser->email);
        $this->assertEquals($socialiteUser->getName(), $resultUser->firstname);
    }

    #[Test]
    public function testGetUserOrCreateActuallyReturnsExistingUser()
    {

        $existinguser = Arr::random($this->users->toArray());

        $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');
        $socialiteUser
            ->shouldReceive('getId')
            ->andReturn($existinguser['id'])
            ->shouldReceive('getName')
            ->andReturn($existinguser['firstname'])
            ->shouldReceive('getEmail')
            ->andReturn($existinguser['email']);

        $user = $this->userRepository->getUserOrCreate($socialiteUser);

        $this->assertEquals($existinguser['id'], $user->id);
        $this->assertEquals($existinguser['firstname'], $user->firstname);
    }

    #[Test]
    public function testGetUserProviderOrCreateActuallyCreatesNewProvider()
    {

        $providers = config('app.oauth_providers');

        self::assertDatabaseMissing('providers',[
            'userId' => $this->detailedUser->id,
            'socialId' => '9352523',
            'provider' => 'google'
        ]);

        $resultProvider = $this->userRepository->getUserProviderOrCreate(
              $userId   = $this->detailedUser->id,
            $socialId = '9352523',
            $provider = 'google');

        $this->assertInstanceOf(Provider::class, $resultProvider);

        $this->assertEquals($userId, $resultProvider->user_id);
        $this->assertEquals($socialId, $resultProvider->provider_id);
        $this->assertEquals($provider, $resultProvider->provider);

        $this->assertDatabaseHas('providers',$resultProvider->toArray());

    }

    #[Test]
    public function testGetUserProviderOrCreateActuallyReturnsExistingProvider()
    {
        $existingProvider = $this->detailedUser->providers()->create([
            'user_id' => (int)$this->detailedUser->id,
            'provider_id' => '9352523',
            'provider' => 'google'
        ]);

        $resultProvider = $this->userRepository->getUserProviderOrCreate($this->detailedUser->id, '9352523', 'google');

        $this->assertInstanceOf(Provider::class, $resultProvider);

        $this->assertEquals($existingProvider->user_id, $resultProvider->user_id);
        $this->assertEquals($existingProvider->provider_id, $resultProvider->provider_id);
        $this->assertEquals($existingProvider->provider, $resultProvider->provider);
    }

    #[Test]
    public function testUpdateUserRoleSuccessfully()
    {
        Artisan::call('db:seed --class=RolesSeeder');

        $role = 'admin';

        $this->userRepository->updateUserRole($this->detailedUser->id, $role);

        $user = User::find($this->detailedUser->id);
        $this->assertTrue($user->hasRole($role));
    }

    #[Test]
    public function testGetUserRoleByEmailReturnsRole()
    {
        Artisan::call('db:seed --class=RolesSeeder');

        $this->detailedUser->assignRole($roleName = 'admin');

        $role = $this->userRepository->getRoleByEmail($this->detailedUser->email);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals($roleName, $role->name);
    }


    #[Test]
    public function testUpdateUserSuccessfully()
    {
        $updatedData = [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'is_active' => 1,
        ];

        $this->userRepository->updateUser($updatedData,$this->detailedUser);

        $updatedUser = $this->userRepository->getUserByEmail($updatedData['email']);

        $this->assertEquals($updatedData['firstname'], $updatedUser->firstname);
        $this->assertEquals($updatedData['lastname'], $updatedUser->lastname);
        $this->assertEquals($updatedData['email'], $updatedUser->email);
        $this->assertEquals($updatedData['is_active'], $updatedUser->is_active);

        $this->assertDatabaseHas('users',$updatedUser->toArray());

    }

    #[Test]
    public function testDeleteUserSuccessfully()
    {
        $user = Arr::random($this->users->toArray());

        $deleteResult = $this->userRepository->deleteUser($user['id']);

        self::assertDatabaseMissing('users',$user);

        $deletedUser = $this->userRepository->getUserByEmail($user['email']);

        $this->assertNull($deletedUser);
    }

    #[Test]
    public function testDeleteUserReturnsExceptionForNonexistentUser()
    {
        $this->expectException(ModelNotFoundException::class);

        $nonExistentUserId = rand();

        $this->userRepository->deleteUser($nonExistentUserId);
    }

    #[Test]
    public function testGetActiveUserByIdReturnsActiveUser()
    {
        $result = $this->userRepository->getActiveUserById($this->detailedUser->id);

        $this->assertInstanceOf(User::class, $result);

        $this->assertEquals($this->detailedUser->id, $result->id);
    }

    #[Test]
    public function testGetActiveUserByIdReturnsNullForInactiveUser()
    {
        $user = User::factory()->create(['is_active' => 0]);

        $result = $this->userRepository->getActiveUserById($user->id);

        $this->assertNull($result);
    }

    #[Test]
    public function testGetUserActiveSubscriptionReturnsActiveSubscription()
    {
        $activeSubscription = Subscription::factory()->create([
            'user_id' => $this->detailedUser->id,
            'plan_id' =>  Plan::factory()->create()->id,
            'is_active' => 1,
        ]);

        $result = $this->userRepository->getUserActiveSubscription($this->detailedUser->id);

        $this->assertInstanceOf(Subscription::class, $result);

        $this->assertEquals($activeSubscription->id, $result->id);
    }

    #[Test]
    public function testGetUserActiveSubscriptionReturnsNullForInactiveSubscription()
    {
        Subscription::factory()->create([
            'user_id' => $this->detailedUser->id,
            'plan_id' => Plan::factory()->create()->id,
            'is_active' => 0,
        ]);

        $result = $this->userRepository->getUserActiveSubscription($this->detailedUser->id);

        $this->assertNull($result);
    }

    #[Test]
    public function testGetUserByIdReturnsUserSuccessfully()
    {
        $result = $this->userRepository->getUserById($this->detailedUser->id);

        $this->assertInstanceOf(User::class, $result);

        $this->assertEquals($this->detailedUser->id, $result->id);
    }

    public function testUpdateUserDetailsUpdatesUserDetails()
    {
        $updateData = [
            'mobile' => Str::random(10),
            'country_code' => $this->faker->countryCode(),
            'age_group' => Arr::random(['teen','adult']),
            'birth_date' => $this->faker->date(),
        ];

        $this->userRepository->updateUserDetails($updateData, $this->detailedUser->userDetails);

        $updatedUserDetails = UserDetails::find($this->detailedUser->userDetails)->first();

        foreach ($updateData as $key => $value) {
            $this->assertEquals($value, $updatedUserDetails->{$key});
        }
    }

}
