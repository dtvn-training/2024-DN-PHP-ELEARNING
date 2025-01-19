import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchListCourse = async () => {
    try {
        const response = await serverAPI.get(`course/list`);
        return response.data?.courses || [];
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to fetch course information");
    }
};

const useListCourse = () => {
    return useQuery(["ListCourse"], () => fetchListCourse(), {
        retry: false,
        onError: (error) => {
            console.error("Courses Info Error:", error.message);
        },
    });
};

export default useListCourse;
