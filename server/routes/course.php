<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CourseViewController;
use App\Http\Controllers\CourseCreateController;
use App\Http\Controllers\CourseModifyController;

Route::get('/view', [CourseViewController::class, 'view']);
Route::post('/create', [CourseCreateController::class, 'create']);
Route::post('/modify', [CourseModifyController::class, 'modify']);
