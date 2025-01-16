import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchLesson = async ({ course_id, lesson_id }) => {
    try {
        const response = await serverAPI.get("lesson/view", {
            params: {
                course_id,
                lesson_id,
            }
        });
        return response.data.lesson;
    } catch (error) {
        throw new Error(
            error.response?.data?.message || "Failed to fetch lesson data"
        );
    }
};

const useViewLesson = (course_id, lesson_id) => {
    return useQuery(
        ["viewLesson", course_id, lesson_id],
        () => fetchLesson({ course_id, lesson_id }),
        {
            enabled: !!course_id && !!lesson_id,
            retry: false,
            onError: (error) => {
                console.error("Lesson View Error:", error.message);
            },
        }
    );
};

export default useViewLesson;
