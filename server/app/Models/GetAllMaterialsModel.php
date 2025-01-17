<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GetAllMaterialsModel extends Model
{

    protected $table = 'materials';
    protected $primaryKey = 'material_id';
    public $timestamps = false;

    protected $fillable = [
        'materials.material_id',
        'materials.material_content',
        'materials.type_id',
        'materials.created_at',
        'materials.updated_at',
    ];

    /**
     * Retrieve all active courses associated with a specific authentication_id, including user information.
     */
    public function getAllMaterials($lesson_id): array
    {
        $materials = self::select(
            'materials.material_id',
            'materials.material_content',
            'materials.type_id',
            'materials.lesson_id',
            'materials.created_at',
            'materials.updated_at',
        )
            ->join('lessons', 'lessons.lesson_id', '=', 'materials.lesson_id')
            ->where('materials.lesson_id', $lesson_id)
            ->where('lessons.deleted_flag', false)
            ->where('materials.deleted_flag', false)
            ->get()
            ->toArray();

        return $materials ?? [];
    }
}
