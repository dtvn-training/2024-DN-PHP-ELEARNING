<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GetCourseBelongModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';

    /**
     * Verify if the course belongs to the authenticated user and return the user ID.
     *
     * @param int $aid - Authentication ID (user's ID).
     * @param int $course_id - ID of the course to verify.
     * @return int|null - The user ID if the course belongs to the user, null otherwise.
     */
    public static function execute(int $aid, int $course_id): ?int
    {
        return self::join('users as u', 'u.user_id', '=', 'courses.user_id')
            ->join('authentications as a', 'a.authentication_id', '=', 'u.authentication_id')
            ->where('a.authentication_id', $aid)
            ->where('courses.course_id', $course_id)
            ->where('u.deleted_flag', false)
            ->where('courses.deleted_flag', false)
            ->value('u.user_id');
    }
}

