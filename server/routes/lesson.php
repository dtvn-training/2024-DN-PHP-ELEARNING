<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnsureCourseBelong;
use App\Http\Middleware\EnsureRoleTeacher;

use App\Http\Controllers\LessonListController;
use App\Http\Controllers\LessonCreateController;

Route::get('/list', [LessonListController::class, 'list'])
    ->middleware([EnsureRoleTeacher::class, EnsureCourseBelong::class]);

Route::post('/create', [LessonCreateController::class, 'create'])
    ->middleware([EnsureRoleTeacher::class, EnsureCourseBelong::class]);
