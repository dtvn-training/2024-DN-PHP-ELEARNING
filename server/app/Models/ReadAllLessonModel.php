<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadAllLessonModel extends Model
{
    protected $table = 'lessons';
    protected $primaryKey = 'lesson_id';
    public $timestamps = false;

    protected $fillable = [
        'lesson_id',
        'lesson_name',
        'course_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Retrieve all lessons for a specific course_id.
     *
     * @param  int  $course_id
     * @return array
     */
    public function getLessonsByCourse(int $course_id): array
    {
        return self::select(
                'lesson_id',
                'lesson_name',
                'created_at',
                'updated_at'
            )
            ->where('course_id', $course_id)
            ->where('deleted_flag', false)
            ->get()
            ->toArray();
    }
}
