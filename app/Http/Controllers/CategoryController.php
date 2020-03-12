<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exceptions\HttpNotFoundException;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse as Response;

class CategoryController extends Controller
{
    /** @var CategoryService $userServcie */
    public $categoryService;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     *
     */
    public function create(Request $request, Response $response)
    {
        $category = $this->categoryService->create($request);

        $response->setData($category);
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     *
     */
    public function update(Request $request, Response $response)
    {
        $category = Category::find($request->route('id'));

        if (!$category) {
            throw new HttpNotFoundException("Category not found with id " . $request->route('id'));
        }

        $category = $this->categoryService->update($request, $category);

        $response->setData($category);
        $response->setStatusCode(200);

        return $response;
    }
}
