import { useMutation, useQueryClient } from "react-query";
import serverAPI from "@Globals/serverAPI";

const generateTranscript = async ({ materialId, materialContent }) => {
    try {
        const response = await serverAPI.post("material/generate", {
            material_id: materialId,
            material_content: materialContent,
        });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to generate transcript");
    }
};

const useGenerateTranscript = () => {
    const queryClient = useQueryClient();

    return useMutation(generateTranscript, {
        onSuccess: () => {
            queryClient.invalidateQueries(['materials']);
        },
    });
};

export default useGenerateTranscript;
