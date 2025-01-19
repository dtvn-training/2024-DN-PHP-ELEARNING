<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GetLessonBelongModel extends Model
{
    protected $table = 'lessons';
    protected $primaryKey = 'lesson_id';

    /**
     * Verify if the lesson belongs to the authenticated user and return the user ID.
     *
     * @param int $aid - Authentication ID (user's ID).
     * @param int $lesson_id - ID of the lesson to verify.
     * @return int|null - The user ID if the lesson belongs to the user, null otherwise.
     */
    public static function execute(int $aid, int $lesson_id): ?int
    {
        return self::join('courses as c', 'c.course_id', '=', 'lessons.course_id')
            ->join('users as u', 'u.user_id', '=', 'c.user_id')
            ->join('authentications as a', 'a.authentication_id', '=', 'u.authentication_id')
            ->where('a.authentication_id', $aid)
            ->where('lessons.lesson_id', $lesson_id)
            ->where('u.deleted_flag', false)
            ->where('c.deleted_flag', false)
            ->where('lessons.deleted_flag', false)
            ->value('u.user_id');
    }
}
