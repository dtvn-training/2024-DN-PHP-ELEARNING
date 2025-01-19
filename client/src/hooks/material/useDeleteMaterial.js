import { useMutation, useQueryClient } from "react-query";
import serverAPI from "@Globals/serverAPI";

const deleteMaterial = async ({ materialId }) => {
    try {
        const response = await serverAPI.post("material/delete", {
            material_id: materialId,
        });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to delete material");
    }
};

const useDeleteMaterial = () => {
    const queryClient = useQueryClient();

    return useMutation(deleteMaterial, {
        onSuccess: () => {
            queryClient.invalidateQueries(['materials']);
        },
    });
};

export default useDeleteMaterial;
