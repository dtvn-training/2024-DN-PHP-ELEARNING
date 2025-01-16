import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const modifyMaterial = async ({ materialId, courseId, lessonId, materialContent }) => {
    try {
        const response = await serverAPI.post("material/modify", {
            material_id: materialId,
            course_id: courseId,
            lesson_id: lessonId,
            material_content: materialContent,
        });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to modify material");
    }
};

const useModifyMaterial = () => {
    return useMutation(modifyMaterial);
};

export default useModifyMaterial;
