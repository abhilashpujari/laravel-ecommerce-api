<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        return response()->json(['message' => 'Hello']);
    }
}
