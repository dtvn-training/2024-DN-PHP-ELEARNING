import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const modifyLesson = async ({ course_id, lesson_id, lesson_name }) => {
    try {
        const response = await serverAPI.post("lesson/modify", {
            course_id,
            lesson_id,
            lesson_name,
        });
        return response.data;
    } catch (error) {
        throw new Error(
            error.response?.data?.message || "Failed to modify lesson data"
        );
    }
};

const useModifyLesson = () => {
    return useMutation(modifyLesson, {
        onError: (error) => {
            console.error("Lesson Modify Error:", error.message);
        },
        onSuccess: (data) => {
            console.log("Lesson modified successfully:", data);
        },
    });
};

export default useModifyLesson;
