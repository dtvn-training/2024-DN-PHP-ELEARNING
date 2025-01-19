import React, { useRef } from "react";
import useModifyMaterial from "@Hooks/material/useModifyMaterial";
import useSetMaterial from "@Hooks/material/useSetMaterial";
import DeleteMaterial from "./DeleteMaterial";

const ModifyMaterial = ({ material, editedContents, setMessage }) => {
    const { mutate: modifyMaterial } = useModifyMaterial();
    const { mutate: uploadFile } = useSetMaterial();
    const fileInputRef = useRef(null);

    const UploadFile = async (material_id, file) => {
        try {
            setMessage(material_id, "Uploading...");
            await uploadFile({ material_id, file });
            setMessage(material_id, "Upload successful!");
        } catch (error) {
            setMessage(material_id, "Upload failed. Please try again.");
        }
    };

    const handleFileChange = async (event) => {
        const file = event.target.files[0];
        if (file) {
            setMessage(material.material_id, "Uploading...");
            await UploadFile(material.material_id, file);
        }
    };

    const handleButtonClick = async () => {
        if (material.type_id === 3) {
            try {
                const contentToUpdate = editedContents || material.material_content;
                setMessage(material.material_id, "Uploading...");
                await modifyMaterial({
                    materialId: material.material_id,
                    materialContent: contentToUpdate,
                });
                setMessage(material.material_id, "Material modified successfully!");
            } catch (error) {
                setMessage(material.material_id, "Failed to modify material. Please try again.");
            }
        } else if (material.type_id === 1 || material.type_id === 2) {
            fileInputRef.current.click();
        }
    };

    return (
        <div className="material-actions">
            <button
                onClick={handleButtonClick}
                className="material-save-button"
            >
                <img
                    className="redner-material-icon"
                    src="/material/icon-save.png"
                    alt="Save"
                />
            </button>
            <input
                ref={fileInputRef}
                type="file"
                accept={material.type_id === 1 ? "video/*" : "image/*"}
                onChange={handleFileChange}
                style={{ display: "none" }}
            />
            <DeleteMaterial materialId={material.material_id} />
        </div>
    );
};

export default ModifyMaterial;
