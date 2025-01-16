import { useMutation, useQueryClient } from "react-query";
import serverAPI from "@Globals/serverAPI";

const addLesson = async ({ course_id, lesson_name }) => {
    if (!course_id || !lesson_name) throw new Error("Course ID and Lesson Name are required");
    try {
        const response = await serverAPI.post("lesson/add", { course_id, lesson_name });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to add the lesson");
    }
};

const useAddLesson = () => {
    const queryClient = useQueryClient();

    return useMutation(addLesson, {
        onSuccess: () => {
            queryClient.invalidateQueries(["AllLessonsInfo"]);
        },
        onError: (error) => {
            console.error("Lesson Addition Error:", error.message);
        },
    });
};

export default useAddLesson;
