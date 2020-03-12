<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Http\Request;

/**
 * Class RegisterController
 * @package App\Http\Controllers
 */
class RegisterController extends Controller
{
    /** @var UserService $userServcie */
    public $userServcie;

    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->userServcie = new UserService();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function register(Request $request, Response $response)
    {
        $this->userServcie->register($request);

        $response->setData([
            'message' => 'Registered successfully'
        ]);

        $response->setStatusCode(200);

        return $response;
    }
}
