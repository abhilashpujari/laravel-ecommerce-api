<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{
    /** @var UserService $userServcie */
    public $userServcie;

    public function __construct()
    {
        $this->userServcie = new UserService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $user = $this->userServcie->authenticate($request);
        return response()->json([
            'user' => $user
        ]);
    }
}
