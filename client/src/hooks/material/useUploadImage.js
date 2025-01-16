import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const uploadImage = async ({ imageFile, courseId, lessonId }) => {
    const formData = new FormData();
    formData.append("image", imageFile);
    formData.append("course_id", courseId);
    formData.append("lesson_id", lessonId);

    try {
        const response = await serverAPI.post("material/media/upload/image", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to upload image");
    }
};

const useUploadImage = () => {
    return useMutation(uploadImage);
};

export default useUploadImage;
