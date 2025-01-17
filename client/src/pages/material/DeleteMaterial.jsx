import React, { useState } from "react";
import { useParams } from "react-router-dom";
import useDeleteMaterial from "@Hooks/material/useDeleteMaterial";
import EnsureMessage from "@Utilities/EnsureMessage";

const DeleteMaterial = ({ materialId, refetch }) => {
    const { course_id, lesson_id } = useParams();
    const [materialToDelete, setMaterialToDelete] = useState(null);
    const deleteMutation = useDeleteMaterial();

    const handleDeleteButtonClick = (materialId) => {
        setMaterialToDelete(materialId);
    };

    const confirmDelete = () => {
        if (materialToDelete) {
            deleteMutation.mutate(
                { courseId: course_id, lessonId: lesson_id, materialId: materialToDelete },
                {
                    onSuccess: () => {
                        setMaterialToDelete(null);
                        refetch();
                    },
                    onError: (error) => {
                        console.error(error.response?.data?.message || "Failed to delete material.");
                        setMaterialToDelete(null);
                    },
                }
            );
        }
    };

    const cancelDelete = () => {
        setMaterialToDelete(null);
    };

    return (
        <div>
            <button
                type="button"
                className="material-delete-button"
                onClick={() => handleDeleteButtonClick(materialId)}
            >
                <img
                    className="redner-material-icon"
                    src="/material/icon-delete.png"
                    alt="Delete"
                />
            </button>

            {materialToDelete && (
                <EnsureMessage
                    message="Are you sure you want to delete this material?"
                    onConfirm={confirmDelete}
                    onCancel={cancelDelete}
                />
            )}
        </div>
    );
};

export default DeleteMaterial;
