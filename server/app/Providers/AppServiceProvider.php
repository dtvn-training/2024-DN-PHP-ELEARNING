<?php

namespace App\Providers;

use App\Contracts\LessonInterface;
use App\Repositories\LessonRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\AuthenticationInterface;
use App\Repositories\AuthenticationRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthenticationInterface::class, AuthenticationRepository::class);
        $this->app->bind(LessonInterface::class, LessonRepository::class);
    }

    public function boot(): void
    {

    }
}
