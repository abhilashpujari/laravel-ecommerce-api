<?php

namespace App\Http\Controllers;

use App\Auth\Identity;
use App\Exceptions\HttpForbiddenException;
use App\Exceptions\HttpNotFoundException;
use App\Product;
use App\Services\ProductService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /** @var ProductService $productService */
    public $productService;

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->productService = new ProductService();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws BindingResolutionException
     */
    public function create(Request $request, Response $response)
    {
        $product = $this->productService->create($request);

        $response->setData($product);
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Exception
     */
    public function delete(Request $request, Response $response)
    {
        $product = Product::find($request->route('id'));

        if (!$product) {
            throw new HttpNotFoundException("Product not found with id " . $request->route('id'));
        }

        $this->productService->delete($request, $product);

        $response->setStatusCode(204);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Exception
     */
    public function list(Request $request, Response $response)
    {
        $categories = Product::all();

        $response->setData(['data' => $categories]);
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws BindingResolutionException
     */
    public function update(Request $request, Response $response)
    {
        $product = Product::find($request->route('id'));

        if (!$product) {
            throw new HttpNotFoundException("Product not found with id " . $request->route('id'));
        }

        $product = $this->productService->update($request, $product);

        $response->setData($product);
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws BindingResolutionException
     */
    public function view(Request $request, Response $response)
    {
        $product = Product::find($request->route('id'));

        if (!$product) {
            throw new HttpNotFoundException("Product not found with id " . $request->route('id'));
        }

        $response->setData($product);
        $response->setStatusCode(200);

        return $response;
    }
}
