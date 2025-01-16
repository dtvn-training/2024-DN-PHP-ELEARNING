import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const deleteMaterial = async ({ courseId, lessonId, materialId }) => {
    const response = await serverAPI.post("material/delete", {
        course_id: courseId,
        lesson_id: lessonId,
        material_id: materialId,
    });
    return response.data;
};

const useDeleteMaterial = () => {
    return useMutation(deleteMaterial);
};

export default useDeleteMaterial;
