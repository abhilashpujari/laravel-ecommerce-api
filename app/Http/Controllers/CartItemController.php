<?php


namespace App\Http\Controllers;

use App\Order;
use App\Services\OrderItemService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Http\Request;

/**
 * Class CartItemController
 * @package App\Http\Controllers
 */
class CartItemController
{
    /**
     * @var OrderService
     */
    protected $orderService;
    /**
     * @var OrderItemService
     */
    protected $orderItemService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->orderItemService = new OrderItemService();
    }

    public function create(Request $request, Response $response)
    {
        $order = Order::where(['cart_id' => $request->get('cart_id')]);

        if (!$order) {
            $order = $this->orderService->create($request);
        }

        $this->orderItemService->create($request);
    }
}
