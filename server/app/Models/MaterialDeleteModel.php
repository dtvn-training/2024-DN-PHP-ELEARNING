<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialDeleteModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'material_id';
    public $timestamps = false;

    /**
     * Delete a material based on lesson ID and material ID.
     */
    public static function execute($material_id): ?bool
    {
        return self::where('material_id', $material_id)
            ->update([
                'deleted_flag' => 1,
                'updated_at' => now()
            ]);
    }
}
