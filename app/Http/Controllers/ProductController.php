<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse as Response;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function list(Request $request, Response $response)
    {
        $response->setData();
        $response->setStatusCode(200);

        return $response;
    }
}
