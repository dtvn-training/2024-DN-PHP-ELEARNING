<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

use App\Contracts\MaterialInterface;

use App\Models\MaterialListModel;
use App\Models\MaterialCreateModel;
use App\Models\MaterialModifyModel;
use App\Models\MaterialDeleteModel;

class MaterialRepository implements MaterialInterface
{
    /**
     * List materials for a specific lesson.
     *
     * @param int $lesson_id
     * @return array|null
     */
    public function list(int $lesson_id): ?array
    {
        return MaterialListModel::execute($lesson_id);
    }

    /**
     * Create a new material.
     *
     * @param array $material_data
     * @return int|null
     */
    public function create(array $material_data): ?int
    {
        return MaterialCreateModel::execute($material_data);
    }

    /**
     * Modify an existing material.
     *
     * @param array $material_data
     * @return bool|null
     */
    public function modify(array $material_data): ?bool
    {
        return MaterialModifyModel::execute($material_data);
    }

    /**
     * Delete a material.
     *
     * @param int $material_id
     * @return bool|null
     */
    public function delete(int $material_id): ?bool
    {
        return MaterialDeleteModel::execute($material_id);
    }

    /**
     * Get the file path for a material based on material ID and file name.
     *
     * @param int $material_id
     * @param string $name
     * @return string|null
     */
    public function get(int $material_id, string $name): ?string
    {
        $filePath = resource_path("materials/$material_id/$name");
        return !file_exists($filePath) ? null : $filePath;
    }

    /**
     * Upload a file (image or video) for a material and save it to the resources folder.
     *
     * @param int $material_id
     * @param UploadedFile $file
     * @return bool|null
     */
    public function set(int $material_id, UploadedFile $file): ?bool
    {
        set_time_limit(0);
        $fileName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();

        if (
            !str_starts_with($mimeType, 'image/')
            && !str_starts_with($mimeType, 'video/')
        ) {
            Log::warning("Unsupported file type: $mimeType for material_id: $material_id");
            return false;
        }

        $targetPath = resource_path("materials/$material_id");
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $isSaved = $file->move($targetPath, $fileName) ? true : false;

        $isModified = MaterialModifyModel::execute([
            'material_id' => $material_id,
            'material_content' => $fileName,
        ]);

        return $isSaved && $isModified;
    }
}
