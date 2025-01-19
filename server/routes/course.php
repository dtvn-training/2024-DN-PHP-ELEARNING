<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnsureCourseBelong;
use App\Http\Middleware\EnsureRoleTeacher;

use App\Http\Controllers\CourseViewController;
use App\Http\Controllers\CourseCreateController;
use App\Http\Controllers\CourseModifyController;
use App\Http\Controllers\CourseDeleteController;

Route::get('/view', [CourseViewController::class, 'view']);

Route::post('/create', [CourseCreateController::class, 'create'])
    ->middleware([EnsureRoleTeacher::class]);

Route::post('/modify', [CourseModifyController::class, 'modify'])
    ->middleware([EnsureRoleTeacher::class, EnsureCourseBelong::class]);

Route::post('/delete', [CourseDeleteController::class, 'delete'])
    ->middleware([EnsureRoleTeacher::class, EnsureCourseBelong::class]);
