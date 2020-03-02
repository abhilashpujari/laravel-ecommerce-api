<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * Class RegisterController
 * @package App\Http\Controllers
 */
class RegisterController extends Controller
{
    /** @var UserService $userServcie */
    public $userServcie;

    public function __construct()
    {
        $this->userServcie = new UserService();
    }

    /**
     * @param Request $request
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->userServcie->register($request);
        return response()->json();
    }
}
