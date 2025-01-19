import { useMutation, useQueryClient } from "react-query";
import serverAPI from "@Globals/serverAPI";

const modifyMaterial = async ({ materialId, materialContent }) => {
    try {
        const response = await serverAPI.post("material/modify", {
            material_id: materialId,
            material_content: materialContent,
        });
        return response;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to modify material");
    }
};

const useModifyMaterial = () => {
    const queryClient = useQueryClient();

    return useMutation(modifyMaterial, {
        onSuccess: () => {
            queryClient.invalidateQueries(['materials']);
        },
    });
};

export default useModifyMaterial;
