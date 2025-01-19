<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonViewModel extends Model
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
    public static function execute(int $lesson_id): ?array
    {
        return self::select('lesson_id', 'lesson_name', 'course_id')
            ->where('lesson_id', $lesson_id)
            ->first()
            ->toArray();
    }
}
