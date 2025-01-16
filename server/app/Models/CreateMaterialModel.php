<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreateMaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'material_id';
    public $timestamps = false;

    /**
     * Delete a material based on lesson ID and material ID.
     */
    public function createMaterial(array $material_information): int
    {
        return self::insertGetId([
            'material_content' => $material_information['material_content'],
            'type_id' => $material_information['type_id'],
            'lesson_id' => $material_information['lesson_id'],
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_flag' => false,
        ]);
    }
}
