<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseBelongModel
{
    protected $table = 'courses';

    /**
     * Verify if the course belongs to the authenticated user and return the user ID.
     *
     * @param int $aid - Authentication ID (user's ID).
     * @param int $course_id - ID of the course to verify.
     * @return int|null - The user ID if the course belongs to the user, null otherwise.
     */
    public function doesCourseBelongToUser(int $aid, int $course_id): ?int
    {
        Log::info("belong aid, cid: $aid, $course_id");
        $userId = DB::table('courses as c')
            ->join('users as u', 'u.user_id', '=', 'c.user_id')
            ->join('authentications as a', 'a.authentication_id', '=', 'u.authentication_id')
            ->where('a.authentication_id', $aid)
            ->where('c.course_id', $course_id)
            ->where('u.deleted_flag', false)
            ->where('c.deleted_flag', false)
            ->value('u.user_id');
            
        Log::info("belong uid: $userId");
        return $userId ?: null;
    }
}
