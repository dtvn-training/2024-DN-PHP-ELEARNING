<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonCreateModel extends Model
{
    protected $table = 'lessons';
    protected $primaryKey = 'lesson_id';

    /**
     * Add a new lesson for the course.
     *
     * @param array $lesson_data - Array containing lesson details.
     * @return int|null - The ID of the newly added lesson.
     */
    public static function execute(array $lesson_data): ?int
    {
        return self::insertGetId([
            'course_id' => $lesson_data['course_id'],
            'lesson_name' => $lesson_data['lesson_name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
