import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

/**
 * Fetch image content for a specific course and lesson.
 * @param {number} courseId - The course ID.
 * @param {number} lessonId - The lesson ID.
 * @param {string} imageName - The name of the image file.
 * @returns {Promise<Blob>} - The image content as a Blob.
 */
const fetchImageContent = async (courseId, lessonId, imageName) => {
    try {
        const response = await serverAPI.get('material/media/get/image', {
            params: { course_id: courseId, lesson_id: lessonId, image_name: imageName },
            responseType: 'blob',
        });
        return URL.createObjectURL(response.data);
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to fetch image");
    }
};

/**
 * React Query hook for fetching image content.
 */
const useGetImage = (courseId, lessonId, imageName) => {
    return useQuery(
        ['image', courseId, lessonId, imageName],
        () => fetchImageContent(courseId, lessonId, imageName),
        {
            staleTime: Infinity, // Prevents automatic re-fetching
            cacheTime: Infinity, // Keeps the data cached indefinitely
            retry: false,
            onError: (error) => {
                console.error("Image Fetch Error:", error.message);
            },
        }
    );
};

export default useGetImage;
