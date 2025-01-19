import { useMutation, useQueryClient } from "react-query";
import serverAPI from "@Globals/serverAPI";

const uploadFile = async ({ material_id, file }) => {
    const formData = new FormData();
    formData.append("file", file);
    formData.append("material_id", material_id);

    try {
        const response = await serverAPI.post("material/set", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        return response;
    } catch (error) {
        console.error("Upload failed:", error);
        throw new Error(error.response?.data?.message || "Failed to upload file");
    }
};

const useSetMaterial = () => {
    const queryClient = useQueryClient();

    return useMutation(uploadFile, {
        onSuccess: () => {
            queryClient.invalidateQueries(['materials']);
        },
    });
};

export default useSetMaterial;
