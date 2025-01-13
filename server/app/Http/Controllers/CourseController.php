<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Contracts\CourseInterface;
use Illuminate\Http\Request;

class CourseController
{
    protected CourseInterface $course;

    public function __construct(CourseInterface $course)
    {
        $this->course = $course;
    }

    /**
     * Handle view course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function viewCourse(Request $request)
    {
        try {
            $course_id = $request->route('course_id');

            $course = $this->course->view($course_id);

            if ($course) {
                return response()->json(['course' => $course], 200);
            }

            return response()->json(['message' => 'Course not found'], 404);
        } catch (Exception $e) {
            Log::error("Error fetching course details: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
