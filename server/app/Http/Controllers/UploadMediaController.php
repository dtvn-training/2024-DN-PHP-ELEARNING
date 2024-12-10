<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controller;

class UploadMediaController extends Controller
{
    /**
     * Handle the upload of a video file.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadVideo(Request $request)
    {
        try {
            $request->validate([
                'video' => 'required|file|mimes:mp4,avi,mov,flv|max:102400', // 100MB max
            ]);

            if ($request->hasFile('video') && $request->file('video')->isValid()) {
                $fileName = $request->file('video')->getClientOriginalName();
                $destinationPath = resource_path('videos');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $request->file('video')->move($destinationPath, $fileName);

                return response()->json([
                    'message' => 'Video uploaded successfully.',
                    'path' => 'videos/' . $fileName,
                ], 200);
            }

            return response()->json([
                'message' => 'Invalid video file.',
            ], 400);
        } catch (\Exception $e) {
            Log::error('Video upload failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while uploading the video.',
            ], 500);
        }
    }
}
