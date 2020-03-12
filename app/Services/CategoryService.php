<?php

namespace App\Services;

use App\Auth\Identity;
use App\Category;
use App\Exceptions\HttpConflictException;
use App\Exceptions\HttpForbiddenException;
use Illuminate\Http\Request;

/**
 * Class CategoryService
 * @package App\Services
 */
class CategoryService extends BaseService
{
    /**
     * @param Request $request
     * @return Category
     */
    public function create(Request $request)
    {
        /** @var Identity $identity */
        $identity = $this->getIdentity();

        if ($identity->isSuperAdmin() || $identity->isAdmin()) {
            $request->validate([
                'name' => 'required'
            ],
                [
                    'name.required' => 'The :attribute field is required.'
                ]);

            $category = new Category();
            $category->fill($request->only($category->getFillable()));
            $this->checkForUniqueCategory($category);
            $category->save();

            return $category;
        } else {
            throw new HttpForbiddenException("You don't have access to this resource");
        }
    }

    /**
     * @param Request $request
     * @param Category $category
     * @throws \Exception
     */
    public function delete(Request $request, Category $category)
    {
        /** @var Identity $identity */
        $identity = $this->getIdentity();

        if ($identity->isSuperAdmin() || $identity->isAdmin()) {
            $category->delete();
        } else {
            throw new HttpForbiddenException("You don't have access to this resource");
        }
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return Category
     */
    public function update(Request $request, Category $category)
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

            $category->fill($request->only($category->getFillable()));
            $this->checkForUniqueCategory($category);
            $category->update();

            return $category;
        } else {
            throw new HttpForbiddenException("You don't have access to this resource");
        }
    }

    /**
     * @param Category $category
     */
    public function checkForUniqueCategory(Category $category)
    {
        // name cannot be null
        if (!$category->name) {
            throw new HttpConflictException("Category name cannot be null or empty.");
        }

        $sameName = Category::where('name', $category->name)->first();
        if ($sameName && $sameName->id != $category->id) {
            throw new HttpConflictException("Category name '{$category->name}' is not unique.");
        }
    }
}
