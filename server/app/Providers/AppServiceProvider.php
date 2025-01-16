<?php

namespace App\Providers;

use App\Repositories\MaterialRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\AuthenticationInterface;
use App\Contracts\MaterialInterface;
use App\Repositories\AuthenticationRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthenticationInterface::class, AuthenticationRepository::class);
        $this->app->bind(MaterialInterface::class, MaterialRepository::class);
    }

    public function boot(): void
    {

    }
}
