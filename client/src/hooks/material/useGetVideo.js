import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

/**
 * Fetch video content for a specific course and lesson.
 * @param {number} courseId - The course ID.
 * @param {number} lessonId - The lesson ID.
 * @param {string} videoName - The name of the video file.
 * @returns {Promise<Blob>} - The video content as a Blob.
 */
const fetchVideoContent = async (courseId, lessonId, videoName) => {
    try {
        const response = await serverAPI.get('material/media/get/video', {
            params: { course_id: courseId, lesson_id: lessonId, video_name: videoName },
            responseType: 'blob',
        });
        return URL.createObjectURL(response.data);
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to fetch video");
    }
};

/**
 * React Query hook for fetching video content.
 */
const useGetVideo = (courseId, lessonId, videoName) => {
    return useQuery(
        ['video', courseId, lessonId, videoName],
        () => fetchVideoContent(courseId, lessonId, videoName),
        {
            staleTime: Infinity, // Prevents automatic re-fetching
            cacheTime: Infinity, // Keeps the data cached indefinitely
            retry: false,
            onError: (error) => {
                console.error("Video Fetch Error:", error.message);
            },
        }
    );
};

export default useGetVideo;
