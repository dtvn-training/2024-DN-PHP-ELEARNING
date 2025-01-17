<?php

namespace App\Repositories;

use App\Contracts\MaterialInterface;
use App\Models\CourseBelongModel;
use App\Models\CreateMaterialModel;
use App\Models\DeleteMaterialModel;
use App\Models\GetAllMaterialsModel;
use App\Models\ModifyMaterialModel;
use Illuminate\Support\Facades\Log;

class MaterialRepository implements MaterialInterface
{
    protected CourseBelongModel $courseBelongModel;
    protected GetAllMaterialsModel $getAllMaterialsModel;
    protected CreateMaterialModel $createMaterialModel;
    protected DeleteMaterialModel $deleteMaterialModel;
    protected ModifyMaterialModel $modifyMaterialModel;

    public function __construct(
        CourseBelongModel $courseBelongModel,
        GetAllMaterialsModel $getAllMaterialsModel,
        CreateMaterialModel $createMaterialModel,
        DeleteMaterialModel $deleteMaterialModel,
        ModifyMaterialModel $modifyMaterialModel
    ) {
        $this->courseBelongModel = $courseBelongModel;
        $this->getAllMaterialsModel = $getAllMaterialsModel;
        $this->createMaterialModel = $createMaterialModel;
        $this->deleteMaterialModel = $deleteMaterialModel;
        $this->modifyMaterialModel = $modifyMaterialModel;
    }

    public function viewAll(int $aid, int $course_id, int $lesson_id): ?array
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $course_id);
            if (!$user_id) {
                throw new \Exception("Course does not belong to the user.");
            }
            return $this->getAllMaterialsModel->getAllMaterials($lesson_id);
        } catch (\Exception $e) {
            Log::error('Error retrieving course lessons: ' . $e->getMessage());
            return null;
        }
    }

    public function add(int $aid, array $material_information): ?int
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $material_information['course_id']);
            if (!$user_id) {
                throw new \Exception("Course does not belong to the user.");
            }
            return $this->createMaterialModel->createMaterial($material_information);
        } catch (\Exception $e) {
            Log::error('Error adding material: ' . $e->getMessage());
            return null;
        }
    }

    public function modify(int $aid, array $material_information): ?bool
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $material_information['course_id']);
            if (!$user_id) {
                throw new \Exception("Course does not belong to the user.");
            }
            
            return $this->modifyMaterialModel->modifyMaterial($material_information);
        } catch (\Exception $e) {
            Log::error('Error modifying material: ' . $e->getMessage());
            return null;
        }
    }

    public function delete(int $aid, array $material_information): ?bool
    {
        try {
            $user_id = $this->courseBelongModel->doesCourseBelongToUser($aid, $material_information['course_id']);
            if (!$user_id) {
                throw new \Exception("Course does not belong to the user.");
            }
            return $this->deleteMaterialModel->deleteMaterial($material_information['lesson_id'], $material_information['material_id']);
        } catch (\Exception $e) {
            Log::error('Error deleting material: ' . $e->getMessage());
            return null;
        }
    }
}
