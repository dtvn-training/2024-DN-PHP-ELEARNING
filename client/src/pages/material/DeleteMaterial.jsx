import React, { useState } from "react";
import useDeleteMaterial from "@Hooks/material/useDeleteMaterial";
import EnsureMessage from "@Utilities/EnsureMessage";

const DeleteMaterial = ({ materialId }) => {
    const [isDelete, setIsDelete] = useState(false);
    const { mutate: deleteMutation } = useDeleteMaterial();

    const handleDeleteButtonClick = () => {
        setIsDelete(true);
    };

    const cancelDelete = () => {
        setIsDelete(false);
    };

    const confirmDelete = async () => {
        await deleteMutation({ materialId });
        setIsDelete(false);
    };

    return (
        <div>
            <button
                type="button"
                className="material-delete-button"
                onClick={handleDeleteButtonClick}
            >
                <img
                    className="redner-material-icon"
                    src="/material/icon-delete.png"
                    alt="Delete"
                />
            </button>

            {isDelete && (
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
