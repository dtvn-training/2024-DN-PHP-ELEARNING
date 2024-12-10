<?php

namespace App\Http\Controllers;

use App\Models\GenerateTranscriptModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;

class GenerateTranscriptController extends Controller
{
    /**
     * Generate transcript from video.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateTranscript(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'speed' => 'required|numeric|between:0.5,2.0',
        ]);

        $videoName = $request->input('name');
        $videoSpeed = $request->input('speed');
        $videoPath = resource_path("videos/$videoName");

        if (!file_exists($videoPath)) {
            return response()->json([
                'message' => 'Video file not found.',
            ], 404);
        }

        $outputBasePath = resource_path('transcripts');

        try {
            $transcriptFolder = (new GenerateTranscriptModel())->processVideoToText(
                $videoPath, 
                $outputBasePath, 
                $videoSpeed
            );

            $transcriptPath = resource_path("{$transcriptFolder}/raw_transcript.txt");

            Log::info("Transcript generation successful, store in {$transcriptPath}");

            if (!file_exists($transcriptPath)) {
                return response()->json([
                    'message' => 'Transcript file not found after processing.',
                ], 500);
            }

            Log::info('Transcript generation successful.');
            return response()->json([
                'message' => 'Transcript generated successfully.',
                'path' => $transcriptFolder,
                'transcript' => file_get_contents($transcriptPath),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Transcript generation failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while generating the transcript.',
            ], 500);
        }
    }
}
