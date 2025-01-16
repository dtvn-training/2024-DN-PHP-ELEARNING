<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Contracts\MaterialInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MaterialController
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
    public function getAll(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|int',
                'lesson_id' => 'required|int',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $aid = $request->session()->get('aid');
            $data = $validator->validated();
            $materials = $this->material->viewAll($aid, $data['course_id'], $data['lesson_id']);
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

    /**
     * Add a new material.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|int',
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

            $aid = $request->session()->get('aid');
            $materialInformation = $validator->validated();
            $materialId = $this->material->add($aid, $materialInformation);

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
                'course_id' => 'required|int',
                'lesson_id' => 'required|int',
                'material_content' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $aid = $request->session()->get('aid');
            $materialInfo = $validator->validated();
            $isUpdated = $this->material->modify($aid, $materialInfo);

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
                'course_id' => 'required|int',
                'lesson_id' => 'required|int',
                'material_id' => 'required|int',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $aid = $request->session()->get('aid');
            $materialInfo = $validator->validated();
            $isDeleted = $this->material->delete($aid, $materialInfo);

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

    /**
     * Upload an image for a lesson and save to the resources folder.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|int',
                'lesson_id' => 'required|int',
                'image' => 'required|image|max:1024000', // Only images
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();
            $course_id = $data['course_id'];
            $lesson_id = $data['lesson_id'];
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();

            // Define the target path within the resources folder
            $targetPath = resource_path("$course_id/$lesson_id");
            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0777, true); // Create directory if it doesn't exist
            }

            // Move the file to the target directory
            $image->move($targetPath, $image_name);

            return response()->json([
                'status' => 'success',
                'message' => 'Image uploaded successfully.',
                'file_path' => resource_path("$course_id/$lesson_id/$image_name"),
            ], 201);
        } catch (Exception $e) {
            Log::error('Error uploading image: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Upload a video for a lesson and save to the resources folder.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadVideo(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|int',
                'lesson_id' => 'required|int',
                'video' => 'required|mimes:mp4,avi,mkv|max:10240000', // Only videos
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();
            $course_id = $data['course_id'];
            $lesson_id = $data['lesson_id'];
            $video = $request->file('video');
            $video_name = $video->getClientOriginalName();

            // Define the target path within the resources folder
            $targetPath = resource_path("$course_id/$lesson_id");
            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0777, true); // Create directory if it doesn't exist
            }

            // Move the file to the target directory
            $video->move($targetPath, $video_name);

            return response()->json([
                'status' => 'success',
                'message' => 'Video uploaded successfully.',
                'file_path' => resource_path("$course_id/$lesson_id/$video_name"),
            ], 201);
        } catch (Exception $e) {
            Log::error('Error uploading video: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
    
    /**
     * Get an image for a lesson.
     *
     * @param Request $request
     * @return StreamedResponse|JsonResponse
     */
    public function getImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|int',
            'lesson_id' => 'required|int',
            'image_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $course_id = $data['course_id'];
        $lesson_id = $data['lesson_id'];
        $image_name = $data['image_name'];

        $path = resource_path("$course_id/$lesson_id/$image_name");

        if (file_exists($path)) {
            $mimeType = mime_content_type($path);

            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            ]);
        }

        return response()->json(['message' => "Image not found at $path"], 404);
    }

    /**
     * Get a video for a lesson.
     *
     * @param Request $request
     * @return StreamedResponse|JsonResponse
     */
    public function getVideo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|int',
            'lesson_id' => 'required|int',
            'video_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $course_id = $data['course_id'];
        $lesson_id = $data['lesson_id'];
        $video_name = $data['video_name'];

        $path = resource_path("$course_id/$lesson_id/$video_name");

        if (file_exists($path)) {
            $mimeType = mime_content_type($path);

            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            ]);
        }

        return response()->json(['message' => "Video not found at $path"], 404);
    }
}
