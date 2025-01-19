<?php

namespace App\Repositories;

use App\Contracts\MaterialInterface;

use App\Models\MaterialCreateModel;
use App\Models\MaterialListModel;

class MaterialRepository implements MaterialInterface
{
    public function list(int $lesson_id): ?array
    {
        return MaterialListModel::execute($lesson_id);
    }

    public function get(int $material_id, string $name): ?string
    {
        $filePath = resource_path("materials/$material_id/$name");
        return !file_exists($filePath) ? null : $filePath;
    }

    public function create(array $material_data): ?int
    {
        return MaterialCreateModel::execute( $material_data);
    }
}
