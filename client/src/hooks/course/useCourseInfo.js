import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchCourseInfo = async (courseId) => {
    try {
        const response = await serverAPI.get(`course/info/${courseId}`);
        return response.data?.course;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to fetch course information");
    }
};

const useCourseInfo = (courseId) => {
    return useQuery(["courseInfo", courseId], () => fetchCourseInfo(courseId), {
        retry: false,
        onError: (error) => {
            console.error("Course Info Error:", error.message);
        },
        enabled: !!courseId,
    });
};

export default useCourseInfo;
