import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const modifyLesson = async ({ lesson_id, lesson_name }) => {
    try {
        const response = await serverAPI.post("lesson/modify", {
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
    return useMutation(modifyLesson);
};

export default useModifyLesson;
