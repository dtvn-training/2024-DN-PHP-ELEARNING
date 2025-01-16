<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteLessonModel extends Model
{
    protected $table = 'lessons';
    protected $primaryKey = 'lesson_id';
    public $timestamps = false;

    /**
     * Delete a lesson based on course_id and lesson_id.
     */
    public function deleteLesson($course_id, $lesson_id): bool
    {
        return self::where('course_id', $course_id)
            ->where('lesson_id', $lesson_id)
            ->where('deleted_flag', false)
            ->update(['deleted_flag' => true]);
    }
}
