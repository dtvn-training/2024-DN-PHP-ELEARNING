import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const addMaterial = async ({ courseId, lessonId, materialContent, typeId }) => {
    try {
        const response = await serverAPI.post("material/add", {
            course_id: courseId,
            lesson_id: lessonId,
            material_content: materialContent,
            type_id: typeId,
        });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to add material");
    }
};

const useAddMaterial = () => {
    return useMutation(addMaterial);
};

export default useAddMaterial;
