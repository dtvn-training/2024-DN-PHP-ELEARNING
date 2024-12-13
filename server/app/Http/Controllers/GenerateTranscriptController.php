<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use App\Models\GenerateTranscriptModel;

class GenerateTranscriptController extends Controller
{
    /**
     * Generate transcript from video file.
     * "en-US": "English"
     * "vi-VN": "Vietnamese"
     * "es-ES": "Spanish"
     * "fr-FR": "French"
     * "de-DE": "German"
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateTranscript(Request $request)
    {
        set_time_limit(0);
        $request->validate([
            'name' => 'required|string',
            'language'=> 'required|string',
        ]);

        try {
            $videoName = $request->query('name');
            $language = $request->query('language');

            $videoPath = resource_path("videos/$videoName");

            Log::info("Requested video: $videoName. Video path: $videoPath");

            if (!file_exists($videoPath)) {
                Log::warning("Video file not found: $videoPath");

                return response()->json([
                    'message' => 'Video file not found.',
                ], 404);
            }

            $outputFolderName = GenerateTranscriptModel::generateTranscript($videoPath, $videoName, $language);

            $transcriptFilePath = resource_path("transcripts/$outputFolderName/raw_transcript.txt");

            if (!file_exists($transcriptFilePath)) {
                Log::error("Transcript file not found: $transcriptFilePath");

                return response()->json([
                    'message' => 'Transcript generation failed. Transcript file not found.',
                ], 500);
            }

            $transcriptContent = file_get_contents($transcriptFilePath);

            return response()->json([
                'message' => 'Transcript generated successfully.',
                'path' => $outputFolderName,
                'transcript' => $transcriptContent,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Transcript generation failed for video: ' . $request->query('name'));
            Log::error('Error message: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while generating the transcript.',
            ], 500);
        }
    }
}
