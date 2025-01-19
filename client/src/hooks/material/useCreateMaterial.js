import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const addMaterial = async ({ lessonId, materialContent, typeId }) => {
    try {
        const response = await serverAPI.post("material/create", {
            lesson_id: lessonId,
            material_content: materialContent,
            type_id: typeId,
        });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to add material");
    }
};

const useCreateMaterial = () => {
    return useMutation(addMaterial);
};

export default useCreateMaterial;
