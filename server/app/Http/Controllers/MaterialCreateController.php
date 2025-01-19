<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Contracts\MaterialInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialCreateController
{
    protected MaterialInterface $material;

    public function __construct(MaterialInterface $material)
    {
        $this->material = $material;
    }

    /**
     * Add a new material.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'lesson_id' => 'required|int',
                'material_content' => 'required|string',
                'type_id' => 'required|int',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $materialId = $this->material->create($validator->validated());

            if ($materialId) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Material added successfully.',
                    'material_id' => $materialId,
                ], 201);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add material.',
            ], 400);
        } catch (Exception $e) {
            Log::error("Error adding material: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}