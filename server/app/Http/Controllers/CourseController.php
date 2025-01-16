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
     * Handle delete course requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCourse(Request $request)
    {
        try {
            $aid = $request->session()->get('aid');
            $course_id = $request->input('course_id');

            if (!$aid || !$course_id) {
                return response()->json(['message' => 'Invalid request data.'], 400);
            }

            $deleted = $this->course->delete($aid, $course_id);

            if ($deleted) {
                return response()->json(['message' => 'Course deleted successfully.'], 200);
            }

            return response()->json(['message' => 'Failed to delete course.'], 400);
        } catch (Exception $e) {
            Log::error("Error deleting course: " . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
}
