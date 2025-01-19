<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CourseViewController;
use App\Http\Controllers\CourseCreateController;

Route::get('/view', [CourseViewController::class, 'view']);
Route::post('/create', [CourseCreateController::class, 'create']);
