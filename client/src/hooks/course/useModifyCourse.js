import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const modifyCourse = async (courseData) => {
    try {
        const response = await serverAPI.post("course/modify", courseData);
        return response.data?.message;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to modify course");
    }
};

const useModifyCourse = () => {
    return useMutation(modifyCourse, {
        onError: (error) => {
            console.error("Modify Course Error:", error.message);
        },
        onSuccess: (data) => {
            console.log("Course modified successfully:", data);
        },
    });
};

export default useModifyCourse;
