<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseDeleteModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $timestamps = false;

    /**
     * Delete a course based on authentication_id and course_id.
     */
    public static function execute($user_id, $course_id): ?bool
    {
        return self::where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->where('deleted_flag', false)
            ->update([
                'deleted_flag' => true,
                'updated_at' => now()
            ]);
    }
}
