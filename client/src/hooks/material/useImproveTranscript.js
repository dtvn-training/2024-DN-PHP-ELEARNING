import { useMutation, useQueryClient } from "react-query";
import serverAPI from "@Globals/serverAPI";

const improveTranscript = async ({ materialId, materialContent, prompt = null }) => {
    try {
        const response = await serverAPI.post("material/improve", {
            material_id: materialId,
            material_content: materialContent,
            prompt: prompt
        });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to improve transcript");
    }
};

const useImproveTranscript = () => {
    const queryClient = useQueryClient();

    return useMutation(improveTranscript, {
        onSuccess: () => {
            window.location.reload();
        },
    });
};

export default useImproveTranscript;
