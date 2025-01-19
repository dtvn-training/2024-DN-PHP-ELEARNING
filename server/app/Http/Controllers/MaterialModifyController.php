<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Contracts\MaterialInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialModifyController
{
    protected MaterialInterface $material;

    public function __construct(MaterialInterface $material)
    {
        $this->material = $material;
    }

    /**
     * Modify a material's content and type.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function modify(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'material_id' => 'required|int',
                'material_content' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $isUpdated = $this->material->modify($validator->validated());

            if ($isUpdated) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Material updated successfully.',
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update material.',
            ], 400);
        } catch (Exception $e) {
            Log::error('Error updating material: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
