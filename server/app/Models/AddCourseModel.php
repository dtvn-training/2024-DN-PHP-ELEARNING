<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Exception;

class AddCourseModel
{
    protected $table = 'courses';

    /**
     * Add a new course for the authenticated user.
     *
     * @param int $user_id - Authentication ID (user's ID).
     * @param array $course_information - Array containing course details.
     * @return int - The ID of the newly added course.
     * @throws Exception - Throws exception on database errors.
     */
    public function addCourse(int $user_id, array $course_information): int
    {
        try {
            $course_id = DB::table($this->table)->insertGetId([
                'user_id' => $user_id,
                'course_name' => $course_information['course_name'],
                'short_description' => $course_information['short_description'],
                'long_description' => $course_information['long_description'],
                'course_price' => $course_information['course_price'],
                'course_duration' => $course_information['course_duration'],
                'course_state' => $course_information['course_state'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $course_id;
        } catch (Exception $e) {
            throw new Exception('Failed to add the course: ' . $e->getMessage());
        }
    }
}
