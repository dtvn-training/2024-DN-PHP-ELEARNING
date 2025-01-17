<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModifyMaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'material_id';
    public $timestamps = false;

    /**
     * Update a material based on material ID.
     *
     * @param array $material_information
     * @return bool
     */
    public function modifyMaterial(array $material_information): bool
    {
        $material = self::find($material_information['material_id']);

        if ($material) {
            $material->material_content = $material_information['material_content'];
            $material->lesson_id = $material_information['lesson_id'];
            $material->updated_at = now();
            
            return $material->save();
        }

        return false;
    }
}
