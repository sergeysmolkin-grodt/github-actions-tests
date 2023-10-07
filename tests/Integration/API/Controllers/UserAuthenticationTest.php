<?php

namespace API\Controllers;


use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class UserAuthenticationTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    protected User $user;

    #[Before]
    public function setUp() : void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');

        $this->user = User::factory()->create(['email' => $this->faker->email]);
    }

    #[Test]
    public function testNonAuthenticatedUserCannotLogout()
    {
        $response = $this->postJson('api/auth/logout');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    #[Test]
    public function testUserRegistersSuccessfully()
    {
        $response = $this->postJson("api/auth/register", $data = self::getUserData());

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonFragment([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);

        self::assertDatabaseHas('users', [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function testUserRegistersViaSocialSuccessfully()
    {

        $response = $this->postJson("api/auth/register", $data = array_merge(self::getUserData(),[
            'loginType' => 'google',
            'socialLoginId' => '90532532'
        ]));

        $this->assertDatabaseHas('providers',[
           'provider_id' => $data['socialLoginId'],
           'provider' => $data['loginType']
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function testUserWhenRegistersDoesntPassUniqueEmailCheck()
    {

        $response = $this->postJson("api/auth/register", array_merge(self::getUserData(), [
            'email' => $this->user->email
        ]));

        $response->assertJson(['error' => 'Email is already exists']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

    }


   public function testUserWhenRegisteredWithPhotoItUploadsToTheStorage()
    {


        $response = $this->postJson("api/auth/register", $user = array_merge(self::getUserData(),[
            'profileImage' => UploadedFile::fake()->image('filename.png', 200, 200)->size(1024),
        ]));


       foreach (Storage::disk()->allFiles('images') as  $file) {
           if (str_contains($file, $user['profileImage']->name)) {
               Storage::assertExists($file);
               break;
           }
       }

        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function testUserWhenRegistersDoesntPassUniqueMobileCheck()
    {

        $user = User::factory()->create();
        $user->userDetails()->create(['mobile' => '0991609801']);

        $response = $this->postJson("api/auth/register", array_merge(self::getUserData(), [
            'mobile' => '0991609801'
        ]));

        $response->assertJson(['error' => 'Mobile number is already registered']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    #[Test]
    public function testReturnsValidationErrorsOnFirstRequiredFieldsWhenRegisters() : void
    {
        $response = $this->postJson('api/auth/register', array_merge(self::getUserData(), [
            'firstname' => ''
        ]));

        $response->assertJsonValidationErrors(['firstname']);

        $response->assertJson([
            'message' => 'The firstname field is required.',
        ]);

        $response->assertValid(['email', 'role', 'ageGroup']);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Test]
    public function testLoginWithExistingUserSuccessfully() : void
    {
        $user = User::factory()->create([
            'email' => fake()->email(),
            'password' => Hash::make('12345678'),
            'is_active' => 1
        ]);

        $response = $this->postJson("api/auth/login", [
            'email' => $user->email,
            'password' => '12345678',
            'loginType' => 'NORMAL',
        ]);

        $response->assertSimilarJson([
           'user' => [
                'id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'profile_image' => $user->profile_image,
                'is_active' => $user->is_active,
                'deleted_at' => $user->deleted_at,
                'email_verified_at' => $user->email_verified_at->format('Y-m-d H:i:s'),
                'remember_token' => $user->remember_token,
                'role' => $user->roles()->get()->toArray()
            ],
            'token' => $response->json('token')
        ]);

        $response->assertSeeText('token');

        $response->assertJsonStructure([
            'user',
            'token',
        ]);

        self::assertDatabaseHas('users', [
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function testUserCannotAuthenticateWithInvalidPassword()
    {
        $response = $this->postJson('api/auth/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
            'loginType' => 'NORMAL'
        ]);

        $response->assertJson([
            'error' => 'User with this password does not exist in the system',
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $this->assertGuest();
    }

    #[Test]
    public function testUserCannotAuthenticateWithInvalidEmail()
    {

        $response = $this->postJson('api/auth/login', [
            'email' => 'wrong@gmail.com',
            'password' => $this->user->password,
            'loginType' => 'NORMAL',
        ]);

        $response->assertJsonFragment([
            "error" => "User with this email does not exist in the system"
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    #[Test]
    public function testUserCannotAuthenticateIntoDisabledByAdminAccount()
    {
        $disabledUser = User::factory()->create([
            'is_active' => 0,
            'email' => 'validgmail@gmail.com',
            'password' => Hash::make('123456789')
        ]);

        $response = $this->postJson('api/auth/login', [
            'email' => $disabledUser->email,
            'password' => '123456789',
            'loginType' => 'NORMAL',
        ]);

        $response->assertJson(['error' => 'Your account has been disabled by administrator please contact to administrator']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    #[Test]
    public function testUserLogoutSuccessfully() : void
    {

        $response = $this->postJson('api/auth/login', [
            'email' => $this->user->email,
            'password' => $this->user->password,
            'loginType' => 'NORMAL',
        ]);

        $headers = ['Authorization' => 'Bearer ' . $response->json('token')];

        $response = $this->actingAs($this->user)->postJson(
            uri: "api/auth/logout",
            headers: $headers
        );

        $response->assertJson([
            'message' => 'Logged out successfully'
        ]);

        $response->assertStatus(Response::HTTP_OK);

    }

    #[Test]
    public function testUserResetsPasswordSuccessfully() : void
    {

        $token = app(PasswordBroker::class)->createToken($this->user);

        $new_password = 'NewtestPassword';

        $response = $this->postJson('api/auth/login', [
            'email' => $this->user->email,
            'password' => $this->user->password,
            'loginType' => 'NORMAL',
        ]);

        $response = $this->postJson("api/auth/reset-password", [
            'token' => $token,
            'email' => $this->user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password
        ]);

        $response->assertJson([
            'status' => 'Your password has been reset.'
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function testCannotResetPasswordWithNoToken() : void
    {

        $new_password = 'testPassword';

        $response = $this->postJson('api/auth/login', [
            'email' => $this->user->email,
            'password' => $this->user->password,
            'loginType' => 'NORMAL',
        ]);

        $response = $this->postJson("api/auth/reset-password", [
            'email' => $this->user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password
        ]);


        $response->assertJson([
            'errors' => ['token' =>
                ["The token field is required."]
            ]
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    #[Test]
    public function testUserLoginWithDeviceDataSuccessfully()
    {
        $user = User::factory()->create([
            'email' => fake()->email(),
            'password' => Hash::make('12345678'),
            'is_active' => 1
        ]);

        $data = UserDevice::factory()->create(['user_id' => $user->id])->toArray();

        $response = $this->postJson("api/auth/login", [
            'email' => $user->email,
            'password' => '12345678',
            'loginType' => 'NORMAL',
            'deviceId' => implode(',',$user->userDevices->pluck('id')->toArray())
        ]);

        $this->assertDatabaseHas('user_devices',[
            'user_id' => $user->id,
            'device_id' => $data['device_id'],
            'device_type' => $data['device_type']
        ]);

        $response->assertStatus(Response::HTTP_OK);

    }

    #[After]
    public function tearDown() : void
    {
        parent::tearDown();

        Storage::disk('local')->deleteDirectory('/images');
    }


}
