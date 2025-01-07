<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\AuthenticationInterface;
use App\Repositories\AuthenticationRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AuthenticationInterface::class, AuthenticationRepository::class);
    }

    public function boot()
    {

    }
}
