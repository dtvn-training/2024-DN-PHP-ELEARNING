<?php

use App\Http\Middleware\EnsureLoggedOut;
use App\Http\Middleware\EnsureRoleTeacher;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MaterialController;
use App\Http\Middleware\EnsureLoggedIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
