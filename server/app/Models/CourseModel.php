<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class CourseModel
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $timestamps = false;

    protected $fillable = [
        'course_name',
        'short_description',
        'long_description',
        'course_price',
        'course_duration',
        'course_state',
        'user_id',
    ];

    /**
     * Retrieve a single active course by ID with user information.
     */
    public function getCourseById($course_id)
    {
        $course = DB::table('courses')
            ->join('users', 'courses.user_id', '=', 'users.user_id')
            ->select(
                'courses.course_id',
                'courses.course_name',
                'courses.short_description',
                'courses.long_description',
                'courses.course_price',
                'courses.course_duration',
                'courses.course_state',
                'courses.created_at',
                'courses.updated_at',
                'users.user_first_name',
                'users.user_last_name',
                'users.user_alias',
                'users.user_email',
                'users.user_phone_number',
                'users.user_address'
            )
            ->where('courses.course_id', $course_id)
            ->where('courses.course_state', true)
            ->where('courses.deleted_flag', false)
            ->where('users.user_state', true)
            ->where('users.deleted_flag', false)
            ->first();

        return $course ? (array) $course : null;
    }
}
