<?php

namespace App\Http\Controllers;

use App\Models\ImproveTranscriptModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImproveTranscriptController
{
    public function improve(Request $request)
    {
        set_time_limit(0);

        $request->validate([
            'path' => 'required|string'
        ]);

        $transcriptPath = $request->input('path');
        $prompt = $request->input('prompt', '');

        try {
            $model = new ImproveTranscriptModel();
            $prePrompt = "Improve the following text while maintaining the same length and depth as the original content. Avoiding any addition or omission.";

            $improvedTranscript = $model->improveTranscript(
                $transcriptPath, 
                $prompt || $prompt == "" ? $prompt : $prePrompt 
            );

            return response()->json([
                'message' => 'Transcript improved successfully.',
                'improved_transcript' => $improvedTranscript,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Improvement failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to improve transcript.',
            ], 500);
        }
    }
}
