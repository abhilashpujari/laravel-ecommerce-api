<?php

namespace App\Http\Controllers;

use App\Auth\Identity;
use App\Category;
use App\Exceptions\HttpForbiddenException;
use App\Exceptions\HttpNotFoundException;
use App\Services\CategoryService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse as Response;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
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
     * @throws \Exception
     */
    public function delete(Request $request, Response $response)
    {
        $category = Category::find($request->route('id'));

        if (!$category) {
            throw new HttpNotFoundException("Category not found with id " . $request->route('id'));
        }

        $this->categoryService->delete($request, $category);

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
        $categories = Category::all();

        $response->setData(['data' => $categories]);
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
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

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws BindingResolutionException
     */
    public function view(Request $request, Response $response)
    {
        /** @var Identity $identity */
        $identity = $this->getIdentity();

        if ($identity->isSuperAdmin() || $identity->isAdmin()) {
            $category = Category::find($request->route('id'));

            if (!$category) {
                throw new HttpNotFoundException("Category not found with id " . $request->route('id'));
            }

            $response->setData($category);
            $response->setStatusCode(200);

            return $response;
        } else {
            throw new HttpForbiddenException("You don't have access to this resource");
        }
    }
}
