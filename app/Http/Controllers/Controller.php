<?php

namespace App\Http\Controllers;

use App\Auth\Identity;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    protected function getIdentity()
    {
        return app()->make(Identity::class);
    }
}
