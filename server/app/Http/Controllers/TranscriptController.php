<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Contracts\TranscriptInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TranscriptController
{
    protected TranscriptInterface $transcript;

    public function __construct(TranscriptInterface $transcript)
    {
        $this->transcript = $transcript;
    }

    /**
     * Generate a transcript for a video.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generate(Request $request): JsonResponse
    {
        try {
            set_time_limit(0);
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|int',
                'lesson_id' => 'required|int',
                'video_name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors occurred.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $aid = $request->session()->get('aid');

            $material_id = $this->transcript->generate($aid, $validator->validated());

            if($material_id === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while generating the transcript.',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Transcript generated successfully.',
                'material_id' => $material_id,
            ], 200);
        } catch (Exception $e) {
            Log::error('Failed to generate transcript: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while generating the transcript.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
