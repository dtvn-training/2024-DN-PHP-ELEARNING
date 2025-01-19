import React, { useState, useRef } from "react";
import MarkdownEditor from "@Utilities/MarkdownEditor";
import useGetMaterial from "@Hooks/material/useGetMaterial";
import './RenderMaterial.css';

const RenderMaterial = ({ material_id, type_id, material_content, refetch }) => {
    const [editedContent, setEditedContent] = useState(material_content);
    const fileInputRef = useRef(null);

    const { data: mediaUrl, isLoading, isError, refetch: mediaRefetch } =
        type_id === 3 ? { data: null, isLoading: false, isError: false }
            : useGetMaterial(material_id, editedContent);

    const renderMedia = (type) => {
        if (isLoading) return <p>Loading...</p>;
        if (isError) return <p>Not Found.</p>;

        if (type === "video") {
            return <video width="100%" controls><source src={mediaUrl} type="video/mp4" /></video>;
        }
        if (type === "image") {
            return <img src={mediaUrl} alt={material_content} style={{ width: "100%", objectFit: "contain" }} />;
        }
        return null;
    };

    const renderText = () => (
        <MarkdownEditor
            className="markdown-editor"
            name="markdown-content"
            content={editedContent}
            setContent={setEditedContent}
        />
    );

    return (
        <div>
            {type_id === 1 && renderMedia("video")}
            {type_id === 2 && renderMedia("image")}
            {type_id === 3 && renderText()}
        </div>
    );
};

export default RenderMaterial;
