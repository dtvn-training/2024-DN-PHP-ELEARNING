import React, { useState } from "react";
import useListMaterial from "@Hooks/material/useListMaterial";
import RenderMaterial from "./RenderMaterial";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import AddMaterial from "./AddMaterial";
import ModifyMaterial from "./ModifyMaterial";
import GenerateTranscript from "./GenerateTranscript";
import ImproveTranscript from "./ImproveTranscript";
import "./MaterialDashboard.css";

const MaterialDashboard = ({ lesson_id }) => {
    const { data: materials, isLoading, error, refetch } = useListMaterial(lesson_id);
    const [messages, setMessages] = useState({});
    const [editedContents, setEditedContents] = useState({});

    const setMessage = (material_id, message) => {
        setMessages((prevMessages) => ({
            ...prevMessages,
            [material_id]: message,
        }));
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
                                    onChange={
                                        material.type_id === 3
                                            ? (e) => handleContentChange(e, material.material_id)
                                            : null
                                    }
                                />
                                {material.type_id === 1 && (
                                    <GenerateTranscript
                                        materialId={material.material_id}
                                        materialContent={material.material_content}
                                    />
                                )}
                                {material.type_id === 3 && (
                                    <ImproveTranscript
                                        materialId={material.material_id}
                                        materialContent={material.material_content}
                                    />
                                )}
                                <ModifyMaterial
                                    material={material}
                                    editedContents={editedContents[material.material_id]}
                                    setMessage={setMessage}
                                />
                                {messages[material.material_id] && (
                                    <div className="message">{messages[material.material_id]}</div>
                                )}
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </div>
    );
};

export default MaterialDashboard;
