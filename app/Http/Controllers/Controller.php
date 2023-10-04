<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use F9Web\ApiResponseHelpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponseHelpers;

    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
    }
}
