<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Contracts\MaterialInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MaterialGetController
{
    protected MaterialInterface $material;

    public function __construct(MaterialInterface $material)
    {
        $this->material = $material;
    }

    /**
     * Get an image for a lesson.
     *
     * @param Request $request
     * @return StreamedResponse|JsonResponse
     */
    public function get(Request $request): mixed
    {
        try {
            $validator = Validator::make($request->all(), [
                'material_id' => 'required|int',
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $path = $this->material->get(
                $validator->validated()['material_id'],
                $validator->validated()['name']
            );

            if ($path) {
                return response()->file($path, [
                    'Content-Type' => mime_content_type($path),
                    'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                ]);
            }

            return response()->json(['message' => "File not found at $path"], 404);
        } catch (Exception $e) {
            Log::error("Logout error:" . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.',], 500);
        }
    }
}
