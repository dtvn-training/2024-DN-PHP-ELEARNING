<?php

namespace App\Providers;

use App\Contracts\LessonInterface;
use App\Repositories\LessonRepository;
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
        $this->app->bind(LessonInterface::class, LessonRepository::class);
    }

    public function boot(): void
    {

    }
}