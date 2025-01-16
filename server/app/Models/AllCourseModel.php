<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllCourseModel extends Model
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
     * Retrieve all active courses associated with a specific authentication_id, including user information.
     */
    public function execute($authentication_id)
    {
        return self::select(
                'courses.course_id',
                'courses.course_name',
                'courses.course_price',
                'courses.course_state',
                'courses.created_at',
                'courses.updated_at',
            )
            ->join('users', 'courses.user_id', '=', 'users.user_id')
            ->where('users.authentication_id', $authentication_id)
            ->where('courses.course_state', true)
            ->where('courses.deleted_flag', false)
            ->where('users.user_state', true)
            ->where('users.deleted_flag', false)
            ->get()
            ->toArray();
    }
}
