<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ViewLessonModel
{
    protected $table = 'lessons';
    protected $primaryKey = 'lesson_id';
    public $timestamps = false;

    protected $fillable = [
        'lesson_id',
        'lesson_name',
        'course_id',
    ];

    /**
     * Retrieve a lesson by its ID.
     *
     * @param int $lesson_id
     * @return array|null
     */
    public function viewLesson(int $lesson_id): array
    {
        return (array)DB::table($this->table)
            ->select('lesson_id', 'lesson_name', 'course_id')
            ->where('lesson_id', $lesson_id)
            ->first();
    }
}
