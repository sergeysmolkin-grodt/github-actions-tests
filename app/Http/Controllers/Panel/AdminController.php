<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\API\UserAuthenticationController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Web\CreateAdminRequest;
use \Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // ToDo: return view with Admin User form
    }

    public function store(CreateAdminRequest $request)
    {
        $validated = $request->validated();

        // Check if User exists by email
        if (! empty($user = $this->userRepository->getUserByEmail($validated['email']))) {
            return $this->respondError(__('Email address is already exist'));
        }
        $this->userRepository->createUser($validated);

        // Assign role for new user
        $user->assignRole($validated['admin_user_type']);

        // ToDo: form necessary response with user data

        return $this->respondWithSuccess(new UserResource($user));
    }
}
