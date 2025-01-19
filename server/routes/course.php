<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CourseViewController;

Route::get('/view', [CourseViewController::class, 'view']);
