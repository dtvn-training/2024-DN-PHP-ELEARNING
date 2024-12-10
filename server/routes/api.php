<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadMediaController;
use App\Http\Controllers\GenerateTranscriptController;
use App\Http\Controllers\ImproveTranscriptController;

Route::post('media/upload', [UploadMediaController::class, 'uploadVideo']);
Route::get('transcript', [GenerateTranscriptController::class, 'generateTranscript']);
Route::get('transcript/improve', [ImproveTranscriptController::class, 'improve']);