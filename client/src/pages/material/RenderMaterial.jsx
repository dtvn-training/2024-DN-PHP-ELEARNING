import React, { useState, useRef } from "react";
import useGetImage from "@Hooks/material/useGetImage";
import useGetVideo from "@Hooks/material/useGetVideo";
import MarkdownEditor from "@Utilities/MarkdownEditor";
import useModifyMaterial from "@Hooks/material/useModifyMaterial";
import useUploadImage from "@Hooks/material/useUploadImage";
import useUploadVideo from "@Hooks/material/useUploadVideo";
import useGenerateTranscript from "@Hooks/material/useGenerateTranscript";
import DeleteMaterial from "./DeleteMaterial";
import './RenderMaterial.css';

const RenderMaterial = ({ material_id, type_id, course_id, lesson_id, material_content, refetch }) => {
    const [editedContent, setEditedContent] = useState(material_content);
    const [message, setMessage] = useState(null);
    const fileInputRef = useRef(null);

    const { mutate: modifyMaterial } = useModifyMaterial({ onSuccess: refetch });
    const { mutate: uploadImage } = useUploadImage();
    const { mutate: uploadVideo } = useUploadVideo();

    const { mutate: generateTranscript, isLoading: isGeneratingTranscript } = useGenerateTranscript(
        (data) => setMessage(`Transcript generated successfully! Material ID: ${data.material_id}`),
        (error) => setMessage(`Error generating transcript: ${error.message}`)
    );

    const { data: mediaUrl, isLoading, isError, refetch: mediaRefetch } =
        type_id === 1 ? useGetVideo(course_id, lesson_id, editedContent) :
            type_id === 2 ? useGetImage(course_id, lesson_id, editedContent) :
                { data: null, isLoading: false, isError: false };

    const UploadFile = async (file) => {
        try {
            setMessage(null);
            if (type_id === 1) {
                await uploadVideo({ videoFile: file, courseId: course_id, lessonId: lesson_id });
                setEditedContent(file.name);
            } else if (type_id === 2) {
                await uploadImage({ imageFile: file, courseId: course_id, lessonId: lesson_id });
                setEditedContent(file.name);
            }

            await modifyMaterial({
                materialId: material_id,
                courseId: course_id,
                lessonId: lesson_id,
                materialContent: file.name,
            });
        } catch (error) {
            console.error("Error uploading or modifying material:", error);
            setMessage("Failed to upload material. Please try again.");
        }
    };

    const handleFileChange = async (event) => {
        const file = event.target.files[0];
        if (file) {
            await UploadFile(file);
            mediaRefetch();
            setMessage("Upload successful!");
        }
    };

    const handleButtonClick = async () => {
        if (type_id === 3) {
            setMessage(null);
            await modifyMaterial({
                materialId: material_id,
                courseId: course_id,
                lessonId: lesson_id,
                materialContent: editedContent,
            });
            setMessage("Upload successful!");
        } else {
            fileInputRef.current.click();
        }
    };

    const handleGenerateTranscript = () => {
        setMessage(null);
        generateTranscript({
            course_id: course_id,
            lesson_id: lesson_id,
            video_name: editedContent,
        });
    };

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
            {message && <div className="upload-message">{message}</div>}

            {type_id === 1 && renderMedia("video")}
            {type_id === 2 && renderMedia("image")}
            {type_id === 3 && renderText()}

            <div className="material-actions">
                <button onClick={handleButtonClick} className="material-save-button">
                    <img className="redner-material-icon" src="/material/icon-save.png" alt="Save" />
                </button>
                <input ref={fileInputRef} type="file" accept={type_id === 1 ? "video/*" : "image/*"} onChange={handleFileChange} style={{ display: 'none' }} />
                {type_id === 1 && (
                    <button
                        onClick={handleGenerateTranscript}
                        disabled={isGeneratingTranscript}
                        className="transcript-button"
                    >
                        {isGeneratingTranscript ? "Generating..." : "Transcript"}
                    </button>
                )}
                <DeleteMaterial materialId={material_id} refetch={refetch} />
            </div>
        </div>
    );
};

export default RenderMaterial;
