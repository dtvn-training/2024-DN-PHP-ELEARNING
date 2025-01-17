<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Exception;

class ModifyCourseModel
{
    protected $table = 'courses';

    /**
     * Modify a course's information if the course belongs to the authenticated user.
     *
     * @param int $aid - Authentication ID (user's ID).
     * @param array $course_information - Array containing course details.
     * @return bool - True if modification was successful, False otherwise.
     * @throws Exception - Throws exception on database errors.
     */
    public function execute(int $user_id, array $course_information): bool
    {
        try {
            $affectedRows = DB::table($this->table)
                ->where('course_id', $course_information['course_id'])
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
            return $affectedRows > 0;
        } catch (Exception $e) {
            throw new Exception('Failed to modify the course: ' . $e->getMessage());
        }
    }
}
