<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseModifyModel extends Model
{
    protected $table = 'courses';

    /**
     * Modify a course's information if the course belongs to the authenticated user.
     *
     * @param int $aid - Authentication ID (user's ID).
     * @param array $course_information - Array containing course details.
     * @return bool - Number if modification was successful, null otherwise.
     */
    public static function execute(int $user_id, array $course_information): ?bool
    {
        return self::where('course_id', $course_information['course_id'])
            ->where('user_id', $user_id)
            ->update([
                'course_name' => $course_information['course_name'],
                'short_description' => $course_information['short_description'],
                'long_description' => $course_information['long_description'],
                'course_price' => $course_information['course_price'],
                'course_duration' => $course_information['course_duration'],
                'course_state' => $course_information['course_state'],
                'updated_at' => now(),
            ]);
    }
}
