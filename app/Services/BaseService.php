<?php

namespace App\Services;

use App\Auth\Identity;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService
{
    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    protected function getIdentity()
    {
        return app()->make(Identity::class);
    }
}
