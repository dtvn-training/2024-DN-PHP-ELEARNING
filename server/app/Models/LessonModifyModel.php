<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonModifyModel extends Model
{
    protected $table = 'lessons';
    protected $primaryKey = 'lesson_id';

    /**
     * Modify a course's information if the course belongs to the authenticated user.
     *
     * @param array $lesson_data- Array containing course details.
     * @return bool - True if modification was successful, False otherwise.
     */
    public static function execute(array $lesson_data): bool
    {
        return self::where('lesson_id', $lesson_data['lesson_id'])
            ->update([
                'lesson_name' => $lesson_data['lesson_name'],
                'updated_at' => now(),
            ]);
    }
}
