<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteMaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'material_id';
    public $timestamps = false;

    /**
     * Delete a material based on lesson ID and material ID.
     */
    public function deleteMaterial($lesson_id, $material_id): bool
    {
        $updatedCount = self::where('lesson_id', $lesson_id)
            ->where('material_id', $material_id)
            ->update(['deleted_flag' => 1]);

        return $updatedCount > 0;
    }
}
