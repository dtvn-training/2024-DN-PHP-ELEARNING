<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\MaterialRepository;
use Illuminate\Support\Facades\Log;

class MaterialTranscriptImproveController
{
    protected MaterialRepository $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    /**
     * Improve the transcript for a material.
     *
     * This method processes a material's content to improve its transcript. 
     * It validates the input and interacts with the MaterialRepository to apply changes.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function improve(Request $request): JsonResponse
    {
        try {
            set_time_limit(0);

            $validator = Validator::make($request->all(), [
                'material_id' => 'required|integer',
                'material_content' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $validatedData = $validator->validated();

            $isImproved = $this->materialRepository->improve(
                $validatedData['material_id'],
                $validatedData['material_content'],
                $request->all()['prompt']
            );

            if ($isImproved) {
                return response()->json([
                    'message' => 'Transcript improved successfully.',
                ], 200);
            }

            return response()->json([
                'message' => 'Transcript improvement failed.',
            ], 422);
        } catch (Exception $e) {
            Log::error('Transcript Improvement Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while improving the transcript.',
            ], 500);
        }
    }
}
