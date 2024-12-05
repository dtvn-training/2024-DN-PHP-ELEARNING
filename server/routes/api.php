<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadMediaController;
use App\Http\Controllers\GenerateTranscriptController;

Route::post('media/upload', [UploadMediaController::class, 'uploadVideo']);
Route::get('media/transcript', [GenerateTranscriptController::class, 'generateTranscript']);