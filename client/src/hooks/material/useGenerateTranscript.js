import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

/**
 * Generate a transcript for a specific video.
 * @param {Object} params - The parameters for generating the transcript.
 * @param {number} params.aid - The user's authentication ID.
 * @param {number} params.course_id - The course ID.
 * @param {number} params.lesson_id - The lesson ID.
 * @param {string} params.video_name - The name of the video file.
 * @param {string} [params.language="en-US"] - The language for the transcript (optional).
 * @returns {Promise<Object>} - The response data containing success message and material ID.
 */
const generateTranscript = async ({ course_id, lesson_id, video_name, language = "en-US" }) => {
    try {
        const response = await serverAPI.post("material/media/transcript", {
            course_id,
            lesson_id,
            video_name,
            language,
        });
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to generate transcript");
    }
};

/**
 * React Query hook for generating a transcript.
 * @param {Function} onSuccess - Callback when the mutation succeeds.
 * @param {Function} onError - Callback when the mutation fails.
 */
const useGenerateTranscript = (onSuccess, onError) => {
    return useMutation(
        (params) => generateTranscript(params),
        {
            onSuccess: (data) => {
                console.log("Transcript generated successfully:", data);
                if (onSuccess) onSuccess(data);
            },
            onError: (error) => {
                console.error("Transcript Generation Error:", error.message);
                if (onError) onError(error);
            },
        }
    );
};

export default useGenerateTranscript;
