<?php

namespace App\Services;

use App\Auth\Identity;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService
{
    protected function getIdentity()
    {
        return app()->make(Identity::class);
    }
}
