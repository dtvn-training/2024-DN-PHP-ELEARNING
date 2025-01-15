import { useMutation, useQueryClient } from "react-query";
import serverAPI from "@Globals/serverAPI";

const deleteCourse = async ({ course_id }) => {
    if (!course_id) throw new Error("Course ID is required");
    try {
        const response = await serverAPI.post(`course/delete`, { course_id });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to delete the course");
    }
};

const useDeleteCourse = () => {
    const queryClient = useQueryClient();

    return useMutation(deleteCourse, {
        onSuccess: () => {
            queryClient.invalidateQueries(["AllCoursesInfo"]);
        },
        onError: (error) => {
            console.error("Delete Course Error:", error.message);
        },
    });
};

export default useDeleteCourse;
