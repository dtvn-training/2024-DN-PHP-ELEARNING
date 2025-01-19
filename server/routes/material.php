<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnsureRoleTeacher;
use App\Http\Middleware\EnsureLessonBelong;
use App\Http\Middleware\EnsureMaterialBelong;

use App\Http\Controllers\MaterialListController;
use App\Http\Controllers\MaterialGetController;
use App\Http\Controllers\MaterialCreateController;

Route::get('/list', [MaterialListController::class, 'list'])
    ->middleware([EnsureRoleTeacher::class, EnsureLessonBelong::class]);

Route::get('/get', [MaterialGetController::class, 'get'])
    ->middleware([EnsureRoleTeacher::class, EnsureMaterialBelong::class]);

Route::post('/create', [MaterialCreateController::class, 'create'])
    ->middleware([EnsureRoleTeacher::class, EnsureLessonBelong::class]);
