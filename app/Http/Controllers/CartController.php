<?php


namespace App\Http\Controllers;

use App\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Http\Request;

/**
 * Class CartController
 * @package App\Http\Controllers
 */
class CartController
{
    /**
     * @var OrderService
     */
    protected $orderService;

    public function create(Request $request, Response $response)
    {
        $order = $this->orderService->create($request);

        $response->setData($order);
        $response->setStatusCode(200);

        return $response;
    }
}
