<?php

use App\Http\Middleware\EnsureLoggedOut;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Middleware\EnsureLoggedIn;
use Illuminate\Support\Facades\Log;

Route::get('test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('auth/status',  function (){
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
});

Route::prefix('course')->group(function () {
    require base_path('routes/course.php');
});
