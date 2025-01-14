import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchAllCoursesInfo = async () => {
    try {
        const response = await serverAPI.get(`course/get-all`);
        return response.data?.courses;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to fetch course information");
    }
};

const useAllCoursesInfo = () => {
    return useQuery(["AllCoursesInfo"], () => fetchAllCoursesInfo(), {
        retry: false,
        onError: (error) => {
            console.error("Courses Info Error:", error.message);
        },
    });
};

export default useAllCoursesInfo;
