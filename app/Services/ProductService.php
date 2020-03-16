<?php

namespace App\Services;

use App\Auth\Identity;
use App\Category;
use App\Exceptions\HttpConflictException;
use App\Exceptions\HttpForbiddenException;
use App\Exceptions\HttpNotFoundException;
use App\Product;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductService extends BaseService
{
    /**
     * @param Request $request
     * @return Product
     * @throws BindingResolutionException
     */
    public function create(Request $request)
    {
        /** @var Identity $identity */
        $identity = $this->getIdentity();

        if ($identity->isSuperAdmin() || $identity->isAdmin()) {
            $request->validate([
                'sku' => 'required|min:3',
                'name' => 'required|min:3',
                'category.id' => 'required|integer'
            ],
                [
                    'sku.*' => 'The :attribute field is required and minimum of 3 characters.',
                    'category.id.*' => 'The :attribute field is required and must be a integer type.',
                    'name.*' => 'The :attribute field is required and minimum of 3 characters.'
                ]);

            $requestData = $request->all();
            $category = Category::find($requestData['category']['id']);

            if (!$category) {
                throw new HttpNotFoundException('Category not found with id ' . $requestData['category']['id']);
            }

            $product = new Product();
            $product->fill($request->only($product->getFillable()));
            $product->category_id = $category->id;
            $this->checkForUniqueProduct($product);
            $product->save();

            return $product;
        } else {
            throw new HttpForbiddenException("You don't have access to this resource");
        }
    }

    /**
     * @param Request $request
     * @param Product $product
     * @throws BindingResolutionException
     * @throws \Exception
     */
    public function delete(Request $request, Product $product)
    {
        /** @var Identity $identity */
        $identity = $this->getIdentity();

        if ($identity->isSuperAdmin() || $identity->isAdmin()) {
            $product->delete();
        } else {
            throw new HttpForbiddenException("You don't have access to this resource");
        }
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return Product
     * @throws BindingResolutionException
     */
    public function update(Request $request, Product $product)
    {
        /** @var Identity $identity */
        $identity = $this->getIdentity();

        if ($identity->isSuperAdmin() || $identity->isAdmin()) {
            $request->validate([
                'is_active' => 'boolean'
            ],
                [
                    'is_active.*' => 'The :attribute field must be boolean.'
                ]);

            $product->fill($request->only($product->getFillable()));
            $this->checkForUniqueProduct($product);
            $product->update();

            return $product;
        } else {
            throw new HttpForbiddenException("You don't have access to this resource");
        }
    }

    /**
     * @param Product $product
     */
    public function checkForUniqueProduct(Product $product)
    {
        // name cannot be null
        if (!$product->sku) {
            throw new HttpConflictException("Product sku cannot be null or empty.");
        }

        $sameProduct = Product::where('sku', $product->sku)
            ->where('name', $product->name)->first();
        if ($sameProduct && $sameProduct->id != $product->id) {
            throw new HttpConflictException("Product sku '{$product->sku}' or name '{$product->name}' is not unique.");
        }
    }
}
