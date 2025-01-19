<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;

use App\Contracts\LessonInterface;

use App\Models\GetUserIDModel;
use App\Models\LessonListModel;

class LessonRepository implements LessonInterface
{
    /**
     * Get course details by course ID.
     *
     * @param  int  $aid
     * @param  int  $course_id
     * @return array|null
     */

    public function list(int $aid, int $course_id): ?array
    {
        $user_id = GetUserIDModel::execute($aid);
        if ($user_id === null) {
            Log::error('User ID not found for authentication ID: ' . $aid);
            return null;
        }
        return LessonListModel::execute($course_id);
    }
}
