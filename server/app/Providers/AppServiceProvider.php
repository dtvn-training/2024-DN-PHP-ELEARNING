<?php

namespace App\Providers;

use App\Contracts\CourseInterface;
use App\Repositories\CourseRepository;
use Illuminate\Support\ServiceProvider;

use App\Contracts\CourseInterface;
use App\Contracts\AuthenticationInterface;

use App\Repositories\AuthenticationRepository;
use App\Repositories\CourseRepository;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthenticationInterface::class, AuthenticationRepository::class);
        $this->app->bind(CourseInterface::class, CourseRepository::class);
    }

    public function boot(): void
    {

    }
}