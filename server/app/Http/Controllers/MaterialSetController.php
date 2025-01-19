<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\MaterialRepository;
use Illuminate\Support\Facades\Log;

class MaterialSetController
{
    protected MaterialRepository $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    /**
     * Upload a file (image or video) for a lesson and save it.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function set(Request $request): JsonResponse
    {
        try {
            set_time_limit(0);
            $validator = Validator::make($request->all(), [
                'material_id' => 'required|int',
                'file' => 'required|file|max:1024000000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();
            $material_id = $data['material_id'];
            $file = $request->file('file');

            $uploadSuccess = $this->materialRepository->set($material_id, $file);

            if (!$uploadSuccess) {
                return response()->json([
                    'message' => 'File upload failed. Unsupported file type or system error.',
                ], 500);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'File uploaded successfully.',
            ], 201);
        } catch (Exception $e) {
            Log::error('Error in MaterialSetController set method: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
