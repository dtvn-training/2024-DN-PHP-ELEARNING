import { useMutation, useQueryClient } from "react-query";
import serverAPI from "@Globals/serverAPI";

const deleteLesson = async ({ course_id, lesson_id }) => {
    if (!course_id || !lesson_id) throw new Error("Course ID and Lesson ID are required");
    try {
        const response = await serverAPI.post("lesson/delete", { course_id, lesson_id });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to delete the lesson");
    }
};

const useDeleteLesson = () => {
    const queryClient = useQueryClient();

    return useMutation(deleteLesson, {
        onSuccess: () => {
            queryClient.invalidateQueries(["AllLessonsInfo"]);
        },
        onError: (error) => {
            console.error("Lesson Deletion Error:", error.message);
        },
    });
};

export default useDeleteLesson;
