<?php

namespace Tests\Integration;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OAuthTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private User $user;

    #[Before]
    protected function setUp() : void
    {
        parent::setUp();

        $this->user = User::factory()->create(['email' => fake()->email]);
    }

    #[Test]
    public function testRedirectToProvider()
    {
        $provider = 'google';
        Socialite::shouldReceive('driver')
            ->once()
            ->with($provider)
            ->andReturnSelf();

        Socialite::shouldReceive('stateless')
            ->once()
            ->andReturnSelf();

        Socialite::shouldReceive('scopes')
            ->once()
            ->with(['openid'])
            ->andReturnSelf();

        Socialite::shouldReceive('redirect')
            ->once()
            ->andReturn(new RedirectResponse('dashboard'));


        $response = $this->get('login/google');

        $response->assertStatus(Response::HTTP_FOUND);
    }

    #[Test]
    public function testAuthenticateWithSocialsReturnsErrorUserDoesntExistsAndRedirectsBack()
    {
        $provider = 'google';

        $socialUser = Mockery::mock('Laravel\Socialite\Two\User');

        $socialUser->shouldReceive('getId')->andReturn(fake()->randomDigit());
        $socialUser->shouldReceive('getName')->andReturn(fake()->firstName);
        $socialUser->shouldReceive('getEmail')->andReturn(fake()->email);

        Socialite::shouldReceive('driver')
            ->once()
            ->with($provider)
            ->andReturnSelf();

        Socialite::shouldReceive('stateless')
            ->once()
            ->andReturnSelf();

        Socialite::shouldReceive('user')
            ->once()
            ->andReturn($socialUser);

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getUserByEmail')
            ->with('test@example.com')
            ->andReturn(null);


        $response = $this->get("/login/$provider/callback");

        $response->assertRedirect(route('login'))->isRedirection();

        $response->assertStatus(Response::HTTP_FOUND);
    }

    #[Test]
    public function testAuthenticateViaGoogleProviderSuccessfully()
    {
        $googleProvider = self::getSocialProviders()[0];

        $socialUser = self::mockSocialUser($this->user);

        self::mockSocialite($socialUser,'google');

        $response = $this->get("/login/{$googleProvider}/callback");

        self::assertDatabaseHas('users',$this->user->toArray());
        self::assertDatabaseHas('providers', [
            'provider' => $googleProvider,
            'provider_id' => $socialUser->getId(),
            'user_id' => $this->user->id
        ]);

        self::assertAuthenticated();
        self::assertNotEmpty($this->user->tokens());

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('dashboard'));
    }

    #[Test]
    public function testAuthenticateViaFacebookProviderSuccessfully()
    {
        $facebookProvider = self::getSocialProviders()[2];

        $socialUser = self::mockSocialUser($this->user);

        self::mockSocialite($socialUser,'facebook');

        $response = $this->get("/login/{$facebookProvider}/callback");

        self::assertDatabaseHas('users',$this->user->toArray());
        self::assertDatabaseHas('providers', [
            'provider' => $facebookProvider,
            'provider_id' => $socialUser->getId(),
            'user_id' => $this->user->id
        ]);

        self::assertAuthenticated();
        self::assertNotEmpty($this->user->tokens());

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect(route('dashboard'));
    }

    #[Test]
    public function testAuthenticateFailsWithInvalidProvider()
    {
        $provider = 'InvalidProvider';

        $socialUser = Mockery::mock('Laravel\Socialite\Two\User');

        $socialUser->shouldReceive('getId')->andReturn(fake()->randomDigit());
        $socialUser->shouldReceive('getName')->andReturn(fake()->firstName);
        $socialUser->shouldReceive('getEmail')->andReturn($this->user->email);
        $socialUser->shouldReceive('getAvatar')->andReturn(fake()->imageUrl());

        Socialite::shouldReceive('driver')
            ->with($provider)
            ->andReturnSelf();

        Socialite::shouldReceive('stateless')
            ->andReturnSelf();

        Socialite::shouldReceive('user')
            ->andReturn($socialUser);


        $response = $this->get("/login/{$provider}/callback");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function getSocialProviders(): array {
        return config('app.oauth_providers');
    }

    public function tearDown() : void
    {
        parent::tearDown();
        Mockery::close();
    }

}
