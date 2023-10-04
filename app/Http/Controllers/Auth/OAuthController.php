<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param string $provider
     * @return JsonResponse|RedirectResponse
     */
    public function redirectToProvider(string $provider): JsonResponse|RedirectResponse
    {
        $validated = $this->validateProvider($provider);

        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)
            ->stateless()
            ->scopes(['openid'])
            ->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param string $provider
     * @return RedirectResponse|JsonResponse
     */
    public function handleProviderCallback(string $provider): RedirectResponse | JsonResponse
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        // Retrieve the user details from the provider
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return redirect()->route('login')->withErrors($exception->getMessage());
        }

        // Check if user exists by $socialUser email
        if (empty($user = $this->userRepository->getUserByEmail($socialUser->getEmail()))) {
            return redirect()->route('login')->withErrors(__('This user does not exist in the system. You need to register first.'));
        }

        // User doesn't exist in the provider table, create a new record
        $user->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $socialUser->getId()
            ],
            [
                'avatar' => $socialUser->getAvatar()
            ]
        );

        // Login User
        Auth::loginUsingId($user->id);

        // Create API token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Redirect to a welcome page or any other page
        return redirect()->route('dashboard');
    }

    /**
     * @param $provider
     * @return JsonResponse|null
     */
    protected function validateProvider(string $provider): JsonResponse|null
    {
        if (!in_array($provider, config('app.oauth_providers'))) {
            return response()->json(['error' => "Please login using " . implode(', ', array_keys(config('services')))], 422);
        }

        return null;
    }
}
