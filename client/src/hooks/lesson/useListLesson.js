import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchListLesson = async (courseId) => {
    try {
        const response = await serverAPI.get(`lesson/list`, { params: { course_id: courseId } });
        return response.data?.lessons || [];
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to fetch lessons");
    }
};

const useListLesson = (courseId) => {
    return useQuery(
        ["lessons", courseId],
        () => fetchListLesson(courseId),
        {
            retry: false,
            onError: (error) => {
                console.error("Lesson Fetch Error:", error.message);
            },
            enabled: !!courseId,
        }
    );
};

export default useListLesson;
