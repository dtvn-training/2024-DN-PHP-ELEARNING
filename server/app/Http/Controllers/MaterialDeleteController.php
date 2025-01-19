<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Contracts\MaterialInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialDeleteController
{
    protected MaterialInterface $material;

    public function __construct(MaterialInterface $material)
    {
        $this->material = $material;
    }

    /**
     * Delete a material (soft delete).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'material_id' => 'required|int',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }
            
            $isDeleted = $this->material->delete($validator->validated()['material_id']);

            if ($isDeleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Material deleted successfully.',
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete material.',
            ], 400);
        } catch (Exception $e) {
            Log::error('Error deleting material: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
