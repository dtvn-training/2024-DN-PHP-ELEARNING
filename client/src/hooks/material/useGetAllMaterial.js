    import { useQuery } from "react-query";
    import serverAPI from "@Globals/serverAPI";

    const fetchAllMaterials = async (courseId, lessonId) => {
        try {
            const response = await serverAPI.get('material/get-all', {
                params: { course_id: courseId, lesson_id: lessonId },
            });
            return response.data.materials ?? [];
        } catch (error) {
            throw new Error(error.response?.data?.message || "Failed to fetch materials");
        }
    };

    const useGetAllMaterials = (courseId, lessonId) => {
        return useQuery(
            ['materials', courseId, lessonId],
            () => fetchAllMaterials(courseId, lessonId),
            {
                retry: false,
                onError: (error) => {
                    console.error("Material Fetch Error:", error.message);
                },
            }
        );
    };

    export default useGetAllMaterials;
