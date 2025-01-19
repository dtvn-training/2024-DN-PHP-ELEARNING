<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnsureRoleTeacher;
use App\Http\Middleware\EnsureLessonBelong;
use App\Http\Middleware\EnsureMaterialBelong;

use App\Http\Controllers\MaterialListController;
use App\Http\Controllers\MaterialGetController;
use App\Http\Controllers\MaterialSetController;
use App\Http\Controllers\MaterialCreateController;
use App\Http\Controllers\MaterialDeleteController;
use App\Http\Controllers\MaterialModifyController;

Route::get('/list', [MaterialListController::class, 'list'])
    ->middleware([EnsureRoleTeacher::class, EnsureLessonBelong::class]);

Route::get('/get', [MaterialGetController::class, 'get'])
    ->middleware([EnsureRoleTeacher::class, EnsureMaterialBelong::class]);

Route::post('/set', [MaterialSetController::class, 'set'])
    ->middleware([EnsureRoleTeacher::class, EnsureMaterialBelong::class]);

Route::post('/create', [MaterialCreateController::class, 'create'])
    ->middleware([EnsureRoleTeacher::class, EnsureLessonBelong::class]);
    
Route::post('/modify', [MaterialModifyController::class, 'modify'])
    ->middleware([EnsureRoleTeacher::class, EnsureMaterialBelong::class]);

Route::post('/delete', [MaterialDeleteController::class, 'delete'])
    ->middleware([EnsureRoleTeacher::class, EnsureMaterialBelong::class]);
