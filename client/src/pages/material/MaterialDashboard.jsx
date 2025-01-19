import React from "react";
import useListMaterial from "@Hooks/material/useListMaterial";
import RenderMaterial from "./RenderMaterial";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import "./MaterialDashboard.css";

const MaterialDashboard = ({ lesson_id }) => {
    const { data: materials, isLoading, error, refetch } = useListMaterial(lesson_id);

    if (error) {
        return <ErrorScene />;
    }

    if (isLoading) {
        return <LoadingScene />;
    }

    return (
        <div className="material-dashboard-container">
            <div className="material-dashboard-content">
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
                                    material_content={material.material_content}
                                    refetch={refetch}
                                />
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </div>
    );
};

export default MaterialDashboard;
