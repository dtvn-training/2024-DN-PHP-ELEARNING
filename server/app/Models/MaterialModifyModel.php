<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialModifyModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'material_id';

    /**
     * Update a material based on material ID.
     *
     * @param array $material_data - Array containing material details.
     * @return bool - True if material was updated, false otherwise.
     */
    public static function execute(array $material_data): bool
    {
        return self::where('material_id', $material_data['material_id'])
            ->update([
                'material_content' => $material_data['material_content'],
                'updated_at' => now(),
            ]);
    }
}
