import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const createCourse = async (courseData) => {
    try {
        const response = await serverAPI.post("course/create", courseData);
        return response.data.course_id;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to create course");
    }
};

const useCreateCourse = () => {
    return useMutation(createCourse, {
        onError: (error) => {
            console.error("Add Course Error:", error.message);
        },
        onSuccess: (data) => {
            console.log("Course created successfully:", data);
        },
    });
};

export default useCreateCourse;
