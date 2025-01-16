<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreateCourseModel extends Model
{
    protected $table = 'courses';

    /**
     * Add a new course for the authenticated user.
     *
     * @param int $user_id - Authentication ID (user's ID).
     * @param array $course_information - Array containing course details.
     * @return int|null - The ID of the newly added course.
     */
    public function execute(int $user_id, array $course_information): ?int
    {
        return self::insertGetId([
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
    }
}
