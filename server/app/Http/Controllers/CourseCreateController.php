<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Contracts\CourseInterface;

class CourseCreateController
{
    protected CourseInterface $course;

    public function __construct(CourseInterface $course)
    {
        $this->course = $course;
    }

    /**
     * Handle modify course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_name' => 'required|string|max:255',
                'short_description' => 'required|string|max:1000',
                'long_description' => 'required|string|max:5000',
                'course_price' => 'required|numeric|min:0',
                'course_duration' => 'required|string|max:100',
                'course_state' => 'required|boolean',
            ]);

            $aid = $request->session()->get('aid');
            $course_id = $this->course->create($aid, $validator->validated());

            if ($course_id) {
                return response()->json([
                    'message' => 'Course added successfully',
                    'course_id' => $course_id,
                ], 201);
            }

            return response()->json(['message' => 'Failed to add course'], 400);
        } catch (Exception $e) {
            Log::error('Error adding course: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
