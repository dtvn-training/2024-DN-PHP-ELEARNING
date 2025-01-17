<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\UploadMediaController;
use App\Http\Controllers\GenerateTranscriptController;
use App\Http\Controllers\ImproveTranscriptController;

use App\Http\Middleware\EnsureLoggedIn;
use App\Http\Middleware\EnsureLoggedOut;
use App\Http\Middleware\EnsureRoleTeacher;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MaterialController;

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

Route::post('media/upload', [UploadMediaController::class, 'uploadVideo']);
Route::get('transcript', [GenerateTranscriptController::class, 'generateTranscript']);
Route::get('transcript/improve', [ImproveTranscriptController::class, 'improve']);

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
        
    Route::get('material/get-all', [MaterialController::class, 'getAll'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::post('material/add', [MaterialController::class, 'add'])
        ->middleware([EnsureRoleTeacher::class]);
        
    Route::post('material/modify', [MaterialController::class, 'modify'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::post('material/delete', [MaterialController::class, 'delete'])
        ->middleware([EnsureRoleTeacher::class]);

    Route::get('material/media/get/image', [MaterialController::class, 'getImage']);
    Route::get('material/media/get/video', [MaterialController::class, 'getVideo']);
    Route::post('material/media/upload/image', [MaterialController::class, 'uploadImage']);
    Route::post('material/media/upload/video', [MaterialController::class, 'uploadVideo']);
});

Route::get('course/view', [CourseController::class, 'view']);
