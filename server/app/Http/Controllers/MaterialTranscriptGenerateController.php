<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\MaterialRepository;
use Illuminate\Support\Facades\Log;

class MaterialTranscriptGenerateController
{
    protected MaterialRepository $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    /**
     * Generate transcript from video file.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request): JsonResponse
    {
        try {
            set_time_limit(0);

            $validator = Validator::make($request->all(), [
                'material_id' => 'required|integer',
                'material_content' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();

            $generatedSuccess = $this->materialRepository->generate(
                $data['material_id'], 
                $data['material_content']
            );

            if ($generatedSuccess) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Transcript generated successfully.',
                ], 200);
            }

            return response()->json([
                'status' => 'failed',
                'message' => 'Transcript generation failed.',
            ], 422);
        } catch (Exception $e) {
            Log::error('Transcript Generation Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while generating the transcript.',
            ], 500);
        }
    }
}
