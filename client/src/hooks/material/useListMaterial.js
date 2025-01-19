    import { useQuery } from "react-query";
    import serverAPI from "@Globals/serverAPI";

    const fetchListMaterial= async (lessonId) => {
        try {
            const response = await serverAPI.get('material/list', {
                params: { lesson_id: lessonId },
            });
            return response.data.materials ?? [];
        } catch (error) {
            throw new Error(error.response?.data?.message || "Failed to fetch materials");
        }
    };

    const useListMaterial = (lessonId) => {
        return useQuery(
            ['materials', lessonId],
            () => fetchListMaterial(lessonId),
            {
                retry: false,
                onError: (error) => {
                    console.error("Material Fetch Error:", error.message);
                },
            }
        );
    };

    export default useListMaterial;
