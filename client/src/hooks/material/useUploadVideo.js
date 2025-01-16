import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const uploadVideo = async ({ videoFile, courseId, lessonId }) => {
    const formData = new FormData();
    formData.append("video", videoFile);
    formData.append("course_id", courseId);
    formData.append("lesson_id", lessonId);

    try {
        const response = await serverAPI.post("material/media/upload/video", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to upload video");
    }
};

const useUploadVideo = () => {
    return useMutation(uploadVideo);
};

export default useUploadVideo;
