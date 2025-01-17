import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchLessons = async (courseId) => {
    try {
        const response = await serverAPI.get(`lesson/get-all`, { params: { course_id: courseId } });
        console.log(response);
        return response.data?.lessons || [];
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to fetch lessons");
    }
};

const useReadAllLesson = (courseId) => {
    return useQuery(
        ["lessons", courseId],
        () => fetchLessons(courseId),
        {
            retry: false,
            onError: (error) => {
                console.error("Lesson Fetch Error:", error.message);
            },
            enabled: !!courseId,
        }
    );
};

export default useReadAllLesson;
