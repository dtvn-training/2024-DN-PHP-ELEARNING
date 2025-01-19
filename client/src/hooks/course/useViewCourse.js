import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchViewCourse = async (courseId) => {
    try {
        const response = await serverAPI.get("course/view", { params: { course_id: courseId } });
        return response.data?.course;
    } catch (error) {
        console.error("Error fetching course:", error);
        throw new Error(error.response?.data?.message || "Failed to fetch course information");
    }
};

const useViewCourse = (courseId) => {
    return useQuery(["courseInfo", courseId], () => fetchViewCourse(courseId), {
        retry: false,
        onError: (error) => {
            console.error("Course Info Error:", error.message);
        },
        enabled: !!courseId,
    });
};

export default useViewCourse;
