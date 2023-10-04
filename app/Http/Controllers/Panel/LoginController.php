<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\API\UserAuthenticationController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function index()
    {
        return view('panel.login.login');
    }

    /**
     * Login for Teacher and Admin role
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attemptWhen($credentials, function (User $user) {
            if (! $user->hasRole('teacher')) {
                return true;
            }
            return $user->teacherOptions->verifications_status == 'verified';
        })) {
            $request->session()->regenerate();
            $user = Auth::user();
            $user->tokens()->delete();
            $user->createToken('auth_token');

            return redirect()->route('dashboard');
        }

        // ToDo: Add 'deleteReminderNotificationDevice'

        return redirect()->back()->withErrors(__('Please check your email and password. Or your account verification is pending by administrator please try after some time or contact to administrator.'));
    }
}
