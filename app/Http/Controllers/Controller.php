<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use F9Web\ApiResponseHelpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponseHelpers;

    protected $userRepository;
    protected int $userId;


    public function __construct()
    {
        if (Auth::check()) {
            $this->userId = Auth::user()->id;
        }
        $this->userRepository = app(UserRepository::class);
    }
}
