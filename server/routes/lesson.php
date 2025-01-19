<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnsureCourseBelong;
use App\Http\Middleware\EnsureRoleTeacher;
use App\Http\Middleware\EnsureLessonBelong;

use App\Http\Controllers\LessonListController;
use App\Http\Controllers\LessonCreateController;
use App\Http\Controllers\LessonDeleteController;
use App\Http\Controllers\LessonModifyController;
use App\Http\Controllers\LessonViewController;

Route::get('/list', [LessonListController::class, 'list'])
    ->middleware([EnsureRoleTeacher::class, EnsureCourseBelong::class]);

Route::post('/create', [LessonCreateController::class, 'create'])
    ->middleware([EnsureRoleTeacher::class, EnsureCourseBelong::class]);

Route::post('/delete', [LessonDeleteController::class, 'delete'])
    ->middleware([EnsureRoleTeacher::class, EnsureLessonBelong::class]);

Route::post('/modify', [LessonModifyController::class, 'modify'])
    ->middleware([EnsureRoleTeacher::class, EnsureLessonBelong::class]);

Route::get('/view', [LessonViewController::class, 'view'])
    ->middleware([EnsureRoleTeacher::class, EnsureLessonBelong::class]);