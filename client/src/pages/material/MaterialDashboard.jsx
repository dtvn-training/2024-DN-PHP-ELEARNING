import React, { useState, useRef } from "react";
import useListMaterial from "@Hooks/material/useListMaterial";
import RenderMaterial from "./RenderMaterial";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import AddMaterial from "./AddMaterial";
import useModifyMaterial from "@Hooks/material/useModifyMaterial";
import useSetMaterial from "@Hooks/material/useSetMaterial";
import "./MaterialDashboard.css";

const MaterialDashboard = ({ lesson_id }) => {
    const { data: materials, isLoading, error, refetch } = useListMaterial(lesson_id);
    const { mutate: modifyMaterial } = useModifyMaterial();
    const { mutate: uploadFile } = useSetMaterial();
    const [message, setMessage] = useState(null);
    const [editedContents, setEditedContents] = useState({});
    const fileInputRefs = useRef({});

    const UploadFile = async (material_id, file) => {
        try {
            await uploadFile({ material_id, file });
            setMessage("Upload successful!");
        } catch (error) {
            setMessage("Upload failed. Please try again.");
        }
    };

    const handleFileChange = async (event, material_id) => {
        const file = event.target.files[0];
        if (file) {
            setMessage("Uploading...");
            await UploadFile(material_id, file);
        }
    };

    const handleButtonClick = async (material_id, type_id) => {
        if (type_id === 3) {
            const contentToUpdate = editedContents[material_id] || '';
            if (!contentToUpdate) {
                setMessage("Please provide content before saving.");
                return;
            }

            setMessage(null);
            try {
                await modifyMaterial({
                    materialId: material_id,
                    materialContent: contentToUpdate,
                });
                setMessage("Material modified successfully!");
            } catch (error) {
                setMessage("Failed to modify material. Please try again.");
            }
        } else if (type_id === 1 || type_id === 2) {
            fileInputRefs.current[material_id].click();
        }
    };

    const handleContentChange = (newContent, material_id) => {
        setEditedContents({
            ...editedContents,
            [material_id]: newContent,
        });
    };

    if (error) {
        return <ErrorScene />;
    }

    if (isLoading) {
        return <LoadingScene />;
    }

    return (
        <div className="material-dashboard-container">
            <div className="material-dashboard-content">
                <AddMaterial refetch={refetch} />

                {materials?.length === 0 ? (
                    <p className="no-materials-message">
                        No materials available! Add your first material by clicking the "Add Material" button above.
                    </p>
                ) : (
                    <ul className="material-list">
                        {materials?.map((material) => (
                            <li key={material.material_id} className="material-item">
                                <RenderMaterial
                                    material_id={material.material_id}
                                    type_id={material.type_id}
                                    material_content={editedContents[material.material_id] || material.material_content}
                                    onChange={material.type_id === 3 ? (e) => handleContentChange(e, material.material_id) : null}
                                />
                                <div className="material-actions">
                                    <button
                                        onClick={() => handleButtonClick(material.material_id, material.type_id)}
                                        className="material-save-button"
                                    >
                                        <img className="redner-material-icon" src="/material/icon-save.png" alt="Save" />
                                    </button>
                                    <input
                                        ref={(el) => (fileInputRefs.current[material.material_id] = el)}
                                        type="file"
                                        accept={material.type_id === 1 ? "video/*" : "image/*"}
                                        onChange={(event) => handleFileChange(event, material.material_id)}
                                        style={{ display: 'none' }}
                                    />
                                </div>
                            </li>
                        ))}
                    </ul>
                )}
                {message && <div className="message">{message}</div>}
            </div>
        </div>
    );
};

export default MaterialDashboard;
