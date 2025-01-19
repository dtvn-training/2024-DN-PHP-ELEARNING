import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchLesson = async ({ lesson_id }) => {
    try {
        const response = await serverAPI.get("lesson/view", {
            params: {
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

const useViewLesson = (lesson_id) => {
    return useQuery(
        ["viewLesson", lesson_id],
        () => fetchLesson({ lesson_id }),
        {
            enabled: !!lesson_id,
            retry: false,
            onError: (error) => {
                console.error("Lesson View Error:", error.message);
            },
        }
    );
};

export default useViewLesson;
