<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnsureCourseBelong;
use App\Http\Middleware\EnsureRoleTeacher;

use App\Http\Controllers\LessonListController;

Route::get('/list', [LessonListController::class, 'list'])
    ->middleware([EnsureRoleTeacher::class, EnsureCourseBelong::class]);
