<?php

namespace App\Repositories;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

use App\Contracts\MaterialInterface;

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
}
