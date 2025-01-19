<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseListModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $timestamps = false;

    protected $fillable = [
        'course_id',
        'course_name',
        'course_price',
        'course_state',
        'user_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Retrieve all active courses associated with a specific authentication_id, including user information.
     */
    public static function execute($user_id): array
    {
        return self::select(
            'course_id',
            'course_name',
            'course_price',
            'course_state',
            'user_id',
            'created_at',
            'updated_at',
        )
            ->where('user_id', $user_id)
            ->where('course_state', true)
            ->where('deleted_flag', false)
            ->get()
            ->toArray();
    }
}
