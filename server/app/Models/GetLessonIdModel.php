<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GetLessonIdModel extends Model
{
    protected $table = 'lessons';
    protected $primaryKey = 'lesson_id';

    /**
     * Get the authorization role by authentication_id
     *
     * @param  int  $aid
     * @return string|null
     */
    public static function viaMaterialId($material_id): ?int
    {
        return self::join('materials', 'lessons.lesson_id', '=', 'materials.lesson_id')
            ->where('materials.material_id', $material_id)
            ->value('lessons.lesson_id');
    }
}
