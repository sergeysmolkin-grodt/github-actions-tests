<?php

namespace Tests\Integration\Services;

use App\Models\User;
use App\Models\UserDevice;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;

    #[Before]
    protected function setUp() : void
    {
        parent::setUp();
        $studentRepository = new StudentRepository(new User(),new UserRepository(new User()));
        $teacherRepository = new TeacherRepository(new User(),new UserRepository(new User()));

        $this->authService = new AuthService(
            new UserRepository(new User()),
            $studentRepository,
            $teacherRepository);

        $this->user = User::create([
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => fake()->email,
            'password' => Hash::make('123456789'),
        ]);
    }

    #[Test]
    public function testUserWithEmailDoesNotExist()
    {
        $requestData = ['email' => 'nonexistent@example.com'];

        $result = $this->authService->loginStudentValidation($requestData);

        $this->assertEquals(__('User with this email does not exist in the system'), $result);
    }

    #[Test]
    public function testDoesntPassInvalidPasswordCheckForNormalLogin()
    {
        $requestData = ['email' => $this->user->email, 'loginType' => 'NORMAL', 'password' => fake()->password];

        $result = $this->authService->loginStudentValidation($requestData);

        $this->assertEquals(__('User with this password does not exist in the system'), $result);
    }

    #[Test]
    public function testInactiveUserCantLogin()
    {
        $this->user->update(['is_active' => false]);

        $requestData = ['email' => $this->user->email, 'loginType' => 'NORMAL', 'password' => '123456789'];
        $result = $this->authService->loginStudentValidation($requestData);

        $this->assertEquals(__('Your account has been disabled by administrator please contact to administrator'), $result);

        $this->assertDatabaseHas('users', ['is_active' => $this->user->is_active]);
    }

    #[Test]
    public function testLoginSuccessfullyReturnsUserInstance()
    {
        $requestData = ['email' => $this->user->email, 'loginType' => 'NORMAL', 'password' => '123456789'];
        $result = $this->authService->loginStudentValidation($requestData);

        $this->assertInstanceOf(User::class, $result);

        $this->assertDatabaseHas('users', $this->user->toArray());
    }

    #[Test]
    public function testCantRegisterIfEmailAlreadyExists()
    {
        $requestData = ['email' => $this->user->email];

        $result = $this->authService->registerStudentValidation($requestData);

        $this->assertEquals(__('Email is already exist'), $result);

    }

    #[Test]
    public function testCantRegisterIfMobileNumberAlreadyExists()
    {
        $this->user->userDetails()->create(['mobile' => $mobile = Str::random(10)]);

        $requestData = ['email' => fake()->email(), 'mobile' => $mobile];

        $result = $this->authService->registerStudentValidation($requestData);

        $this->assertEquals(__('Mobile number is already registered'), $result);
    }

    #[Test]
    public function testValidateRegistrationSuccessfully()
    {
        $requestData = ['email' => fake()->email, 'mobile' => '1234567890'];

        $result = $this->authService->registerStudentValidation($requestData);

        $this->assertNull($result); // null for no validation errors
    }

    #[Test]
    public function testCreateUserDataForTeacher()
    {
        $user = $this->authService->createUserData(array_merge(self::getUserData(), ['role' => 'teacher']));

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->id);

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('user_details', $user->userDetails->toArray());
        $this->assertDatabaseHas('teacher_options', ['user_id' => $user->id]);
    }

    #[Test]
    public function testCreateUserDataForStudent()
    {
        $user = $this->authService->createUserData(array_merge(self::getUserData(), ['role' => 'student']));

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->id);

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('user_details', $user->userDetails->toArray());
        $this->assertDatabaseHas('student_options', ['user_id' => $user->id]);
        $this->assertDatabaseHas('student_reminders_options', ['user_id' => $user->id]);
    }

    #[Test]
    public function testCreateUserDeviceData()
    {
        $requestData = [
            'deviceId' => rand(),
            'deviceType' => fake()->word,
            'deviceToken' => rand(),
            'OSVersion' => fake()->word,
            'brand' => fake()->word,
            'model' => fake()->word,
        ];

        $userDevice = $this->authService->createUserDeviceData($requestData, $this->user->id);

        $this->assertInstanceOf(UserDevice::class, $userDevice);

        $this->assertDatabaseHas('user_devices', $userDevice->toArray() + ['user_id' => $this->user->id]);
    }


}
