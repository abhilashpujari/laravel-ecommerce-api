<?php

namespace App\Providers;

use App\Auth\Auth;
use App\Auth\Identity;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Identity::class, function ($app) {
            try {
                $decodedToken = Auth::decodeAuthToken(request());

                $role = $decodedToken['role'];
                $id = $decodedToken['id'];
                $fullName = $decodedToken['fullName'];
            } catch (\Exception $e) {
                $role = Config::get('role.guest');
                $id = 0;
                $fullName = '';
            }

            return new Identity($id, $role, $fullName);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::$snakeAttributes = false;
        Schema::defaultStringLength(191);
    }
}
