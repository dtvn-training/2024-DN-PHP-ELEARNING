<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AddLessonModel extends Model
{
    protected $table = 'lessons';

    /**
     * Retrieve all active courses associated with a specific authentication_id, including user information.
     */
    public function addLesson(array $lesson_information): int
    {
        try {
            $course_id = DB::table($this->table)->insertGetId([
                'course_id' => $lesson_information['course_id'],
                'lesson_name' => $lesson_information['lesson_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $course_id;
        } catch (Exception $e) {
            throw new Exception('Failed to add the course: ' . $e->getMessage());
        }
    }
}
