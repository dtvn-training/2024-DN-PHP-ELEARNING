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

        try {
            $model = new ImproveTranscriptModel();
            $improvedTranscript = $model->improveTranscript($transcriptPath);

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
