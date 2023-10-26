<?php

namespace Tests\Integration\Services;

use App\DataTransferObjects\BecomeTeacherData;
use App\Exceptions\CouldNotBecomeTeacherException;
use App\Models\User;
use App\Models\UserDetails;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $userService;

    #[Before]
    protected function setUp() : void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');

        $userRepo = new UserRepository(new User());

        $this->userService = new UserService($userRepo,
            new StudentRepository(new User(),$userRepo),
            new TeacherRepository(new User(),$userRepo));
    }

    #[Test]
    public function testGetUsersByRoleTeacher()
    {
        $user1 = User::factory()->create()->assignRole('teacher');
        UserDetails::create(['user_id' => $user1->id]);

        $request = (object)[
            'role' => 'teacher'
        ];

        $studentUsers = $this->userService->getUsers($request);

        foreach ($studentUsers as $user) {
            $this->assertEquals('teacher', $user1->getRoleNames()->first());
            $this->assertTrue($user->relationLoaded('userDetails'));
            $this->assertTrue($user->relationLoaded('teacherOptions'));
        }
    }

    public function testGetUsersByRoleStudent()
    {
        $user1 = User::factory()->create()->assignRole('student');
        $user1->userDetails()->create(['mobile' => Str::random()]);
        $user1->studentOptions()->create(['has_email_notification' => true]);

        $request = (object)[
            'role' => 'student',
        ];

        $studentUsers = $this->userService->getUsers($request);

        foreach ($studentUsers as $user) {
            $this->assertEquals('student', $user1->getRoleNames()->first());
            $this->assertTrue($user->relationLoaded('userDetails'));
            $this->assertTrue($user->relationLoaded('studentOptions'));
        }
    }


    #[Test]
    public function testGetAllUsers()
    {
        $student = User::factory()->create(['email' => fake()->email])->assignRole('student');
        $student->userDetails()->create(['mobile' => $stPhone = Str::random()]);

        $teacher = User::factory()->create()->assignRole('teacher');
        $teacher->userDetails()->create(['mobile' => $tePhone = Str::random()]);

        $request = [];

        $allUsers = $this->userService->getUsers($request);

        $this->assertCount(2, $allUsers);

        $this->assertEquals('student', $student->getRoleNames()->first());
        $this->assertEquals($stPhone, $student->userDetails->mobile);

        $this->assertEquals('teacher', $teacher->getRoleNames()->first());
        $this->assertEquals($tePhone, $teacher->userDetails->mobile);

    }

    #[Test]
    public function testBecomeTeacherSuccessfully()
    {
        $user = User::factory()->create()->assignRole('student');
        UserDetails::create(['user_id' => $user->id]);
        Auth::login($user);

        $teacherData = new BecomeTeacherData('male',  $bd = fake()->date);

        $this->userService->becomeTeacher($teacherData);

        $this->assertTrue($user->hasRole('teacher'));

        $this->assertEquals('male', $user->userDetails->gender);
        $this->assertEquals($bd, $user->userDetails->birth_date);

        $this->assertTrue($user->teacherOptions->exists());
    }

    #[Test]
    public function testCantBecomeTeacherIfUserAlreadyTeacher()
    {
        $user = User::factory()->create()->assignRole('teacher');
        Auth::login($user);

        $teacherData = new BecomeTeacherData('male',  fake()->date);

        try {
            $this->userService->becomeTeacher($teacherData);
        } catch (CouldNotBecomeTeacherException $e) {
            $this->assertEquals('User is already a teacher', $e->getMessage());
        }

        $this->assertTrue($user->hasRole('teacher'));
    }





}
