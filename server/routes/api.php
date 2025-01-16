<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

use App\Http\Middleware\EnsureLoggedIn;
use App\Http\Middleware\EnsureLoggedOut;
use App\Http\Middleware\EnsureRoleTeacher;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;

Route::get('test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('auth/status',  function () {
    try {
        return response()->json(['authenticated' => session()->has('aid')], 200);
    } catch (Exception $e) {
        Log::error("Error in auth/status:" . $e->getMessage());
        return response()->json(['message' => 'An error occurred.'], 500);
    }
});

Route::middleware([EnsureLoggedOut::class])->group(function (): void {
    Route::post('auth/login', [LoginController::class, 'login']);
});

Route::middleware([EnsureLoggedIn::class])->group(function (): void {
    Route::post('auth/logout', [LogoutController::class, 'logout']);

    Route::get('course/get-all', [CourseController::class, 'getAll'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::post('course/modify', [CourseController::class, 'modify'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::post('course/create', [CourseController::class, 'create'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::post('course/delete', [CourseController::class, 'delete'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::get('lesson/get-all', [LessonController::class, 'getAllLesson'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::post('lesson/add', [LessonController::class, 'addLesson'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::post('lesson/delete', [LessonController::class, 'deleteLesson'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::get('lesson/view', [LessonController::class, 'viewLesson'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::post('lesson/modify', [LessonController::class, 'modifyLesson'])
        ->middleware([EnsureRoleTeacher::class]);
        
});

Route::get('course/view', [CourseController::class, 'view']);
