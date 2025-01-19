import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchContent = async (material_id, name) => {
    try {
        const response = await serverAPI.get('material/get', {
            params: { material_id, name: name },
            responseType: 'blob',
        });
        return URL.createObjectURL(response.data);
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to fetch video");
    }
};

const useGetMaterial = (material_id, name) => {
    return useQuery(
        ['video', material_id, name],
        () => fetchContent(material_id, name),
        {
            staleTime: Infinity,
            cacheTime: Infinity,
            retry: false,
            onError: (error) => {
                console.error("Video Fetch Error:", error.message);
            },
        }
    );
};

export default useGetMaterial;
