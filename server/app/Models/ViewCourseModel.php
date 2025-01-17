<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewCourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $timestamps = false;

    /**
     * Retrieve a single active course by ID with user information.
     */
    public function execute($course_id)
    {
        return (array) self::select(
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
        )->join('users', 'courses.user_id', '=', 'users.user_id')
            ->where('courses.course_id', $course_id)
            ->where('courses.course_state', true)
            ->where('courses.deleted_flag', false)
            ->where('users.user_state', true)
            ->where('users.deleted_flag', false)
            ->first()
            ->toArray();
    }
}
