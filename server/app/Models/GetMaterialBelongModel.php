<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GetMaterialBelongModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'material_id';

    /**
     * Verify if the material belongs to the authenticated user and return the user ID.
     *
     * @param int $aid - Authentication ID (user's ID).
     * @param int $material_id - ID of the material to verify.
     * @return int|null - The user ID if the material belongs to the user, null otherwise.
     */
    public static function execute(int $aid, int $material_id): ?int
    {
        return self::join('lessons as l', 'l.lesson_id', '=', 'materials.lesson_id')
            ->join('courses as c', 'c.course_id', '=', 'l.course_id')
            ->join('users as u', 'u.user_id', '=', 'c.user_id')
            ->join('authentications as a', 'a.authentication_id', '=', 'u.authentication_id')
            ->where('a.authentication_id', $aid)
            ->where('materials.material_id', $material_id)
            ->where('u.deleted_flag', false)
            ->where('c.deleted_flag', false)
            ->where('l.deleted_flag', false)
            ->where('materials.deleted_flag', false)
            ->value('u.user_id');
    }
}
