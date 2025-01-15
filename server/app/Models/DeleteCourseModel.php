<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteCourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $timestamps = false;

    protected $fillable = [
        'course_id',
        'course_name',
        'course_price',
        'course_state',
        'created_at',
        'updated_at',
    ];

    /**
     * Delete a course based on authentication_id and course_id.
     */
    public function deleteCourseByAuthIdAndCourseId($authentication_id, $course_id): bool
    {
        return self::join('users', 'courses.user_id', '=', 'users.user_id')
            ->where('users.authentication_id', $authentication_id)
            ->where('courses.course_id', $course_id)
            ->where('courses.deleted_flag', false)
            ->where('users.user_state', true)
            ->where('users.deleted_flag', false)
            ->update(['courses.deleted_flag' => true]);
    }
}
