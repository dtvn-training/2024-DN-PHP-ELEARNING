import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const addCourse = async (courseData) => {
    try {
        const response = await serverAPI.post("course/add", courseData);
        return response.data.course_id;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to add course");
    }
};

const useAddCourse = () => {
    return useMutation(addCourse, {
        onError: (error) => {
            console.error("Add Course Error:", error.message);
        },
        onSuccess: (data) => {
            console.log("Course added successfully:", data);
        },
    });
};

export default useAddCourse;
