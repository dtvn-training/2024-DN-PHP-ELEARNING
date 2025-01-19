<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Contracts\MaterialInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialListController
{
    protected MaterialInterface $material;

    public function __construct(MaterialInterface $material)
    {
        $this->material = $material;
    }

    /**
     * Handle retrieving materials for a specific course and lesson.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'lesson_id' => 'required|int',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $materials = $this->material->list( $validator->validated()['lesson_id']);

            if ($materials !== null) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Materials retrieved successfully.',
                    'materials' => $materials,
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve materials or no data found.',
            ], 404);
        } catch (Exception $e) {
            Log::error("Material retrieval error: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
