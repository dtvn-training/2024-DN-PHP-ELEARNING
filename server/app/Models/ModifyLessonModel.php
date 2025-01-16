<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModifyLessonModel
{
    protected $table = 'lessons';

    /**
     * Modify a course's information if the course belongs to the authenticated user.
     *
     * @param array $lesson_information - Array containing course details.
     * @return bool - True if modification was successful, False otherwise.
     * @throws Exception - Throws exception on database errors.
     */
    public function modifyLesson(array $lesson_information): bool
    {
        try {
            $affectedRows = DB::table($this->table)
                ->where('course_id', $lesson_information['course_id'])
                ->where('lesson_id', $lesson_information['lesson_id'])
                ->update([
                    'lesson_name' => $lesson_information['lesson_name'],
                    'updated_at' => now(),
                ]);
                Log::info($affectedRows);
            return $affectedRows > 0;
        } catch (Exception $e) {
            throw new Exception('Failed to modify the course: ' . $e->getMessage());
        }
    }
}
