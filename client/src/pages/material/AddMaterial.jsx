import useCreateMaterial from "@Hooks/material/useCreateMaterial";
import { useParams } from "react-router-dom";

const AddMaterial = ({ refetch }) => {
    const { course_id, lesson_id } = useParams();
    const addMutation = useCreateMaterial();

    const handleAddMaterial = (type) => {
        let materialContent = "";
        if (type === "video") {
            materialContent = "new_video.png";
        } else if (type === "image") {
            materialContent = "new_image.png";
        } else if (type === "text") {
            materialContent = "New Text";
        }

        const typeId = type === "video" ? 1 : type === "image" ? 2 : 3;

        addMutation.mutate(
            { courseId: course_id, lessonId: lesson_id, materialContent, typeId },
            {
                onSuccess: () => {
                    refetch();
                },
                onError: (error) => {
                    console.error(error.response?.data?.message || `Failed to add ${type}.`);
                },
            }
        );
    };

    return (
        <div className="add-material-buttons">
            <button
                type="button"
                className="material-add-button"
                onClick={() => handleAddMaterial("text")}
            >
                <img className="material-icon" src="/material/icon-add.png" alt="Add Text" />
                Text
            </button>
            <button
                type="button"
                className="material-add-button"
                onClick={() => handleAddMaterial("image")}
            >
                <img className="material-icon" src="/material/icon-add.png" alt="Add Image" />
                Image
            </button>
            <button
                type="button"
                className="material-add-button"
                onClick={() => handleAddMaterial("video")}
            >
                <img className="material-icon" src="/material/icon-add.png" alt="Add Video" />
                Video
            </button>
        </div>
    );
};

export default AddMaterial;