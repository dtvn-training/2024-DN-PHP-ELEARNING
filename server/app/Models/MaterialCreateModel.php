<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCreateModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'material_id';
    public $timestamps = false;

    /**
     * Delete a material based on lesson ID and material ID.
     */
    public static function execute(array $material_data): ?int
    {
        return self::insertGetId([
            'material_content' => $material_data['material_content'],
            'type_id' => $material_data['type_id'],
            'lesson_id' => $material_data['lesson_id'],
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_flag' => false,
        ]);
    }
}
