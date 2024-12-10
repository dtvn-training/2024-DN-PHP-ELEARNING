import React, { useState } from "react";
import axios from "axios";
import ReactMarkdown from "react-markdown";
import "./UploadVideo.css";

function UploadVideo() {
    const [videoFile, setVideoFile] = useState(null);
    const [previewUrl, setPreviewUrl] = useState(null);
    const [transcript, setTranscript] = useState(null);
    const [improvedTranscript, setImprovedTranscript] = useState(null);
    const [uploadedVideoPath, setUploadedVideoPath] = useState(null); // Save uploaded video path
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState("");

    const MAX_FILE_SIZE = 100 * 1024 * 1024; // 100 MB

    const handleFileChange = (event) => {
        const file = event.target.files[0];

        if (!file) return;

        if (file.size > MAX_FILE_SIZE) {
            setMessage("File is too large. Maximum size is 100 MB.");
            return;
        }

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
        }

        setPreviewUrl(null);

        setTimeout(() => {
            setVideoFile(file);
            setPreviewUrl(URL.createObjectURL(file));

            // Reset states for new upload
            setTranscript(null);
            setImprovedTranscript(null);
            setUploadedVideoPath(null); // Clear previous video path
            setMessage("");
        }, 100);

        event.target.value = null;
    };

    const handleUpload = async () => {
        if (!videoFile) {
            setMessage("Please select a video file.");
            return;
        }

        const formData = new FormData();
        formData.append("video", videoFile);

        setLoading(true);
        setMessage("");
        setTranscript(null);
        setImprovedTranscript(null);

        try {
            const response = await axios.post(
                "http://localhost:8000/api/media/upload",
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }
            );

            setMessage("Video uploaded successfully!");
            const videoPath = response.data.path;
            setUploadedVideoPath(videoPath); // Save the uploaded video path
            const videoName = videoPath.split("/").pop();
            fetchTranscript(videoName);
        } catch (error) {
            setMessage(
                error.response?.data?.message ||
                "Error uploading video. Please try again."
            );
        } finally {
            setLoading(false);
        }
    };

    const fetchTranscript = async (videoName) => {
        setLoading(true);
        setMessage("Generating transcript...");

        try {
            const response = await axios.get(
                `http://localhost:8000/api/transcript?name=${videoName}&speed=1.0`
            );

            setTranscript(response.data.transcript);
            setMessage("Transcript generated successfully.");
            fetchImprovedTranscript(response.data.path);
        } catch (error) {
            setMessage(
                error.response?.data?.message ||
                "Error generating transcript. Please try again."
            );
        } finally {
            setLoading(false);
        }
    };

    const fetchImprovedTranscript = async (transcriptPath) => {
        setLoading(true);
        setMessage("Improving transcript...");

        try {
            const response = await axios.get(
                `http://localhost:8000/api/transcript/improve?path=${transcriptPath}`
            );

            setImprovedTranscript(response.data.improved_transcript);
            setMessage("Improved transcript generated successfully.");
        } catch (error) {
            setMessage(
                error.response?.data?.message ||
                "Error improving transcript. Showing raw transcript instead."
            );
        } finally {
            setLoading(false);
        }
    };

    const handleReGenerateTranscript = async () => {
        if (!uploadedVideoPath) {
            setMessage("No uploaded video to re-generate transcript.");
            return;
        }

        setLoading(true);
        setMessage("Re-generating transcript...");

        try {
            const videoName = uploadedVideoPath.split("/").pop();
            fetchTranscript(videoName);
        } catch (error) {
            setMessage(
                error.response?.data?.message ||
                "Error re-generating transcript. Please try again."
            );
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="upload-video-container">
            <h2>Upload Video</h2>
            <input type="file" accept="video/*" onChange={handleFileChange} />

            {previewUrl && (
                <div className="video-preview-container">
                    <video width="300" controls>
                        <source src={previewUrl} type="video/mp4" />
                        Your browser does not support the video tag.
                    </video>
                </div>
            )}

            <button onClick={handleUpload} disabled={loading}>
                {loading ? "Processing..." : "Upload and Generate Transcript"}
            </button>

            {uploadedVideoPath && (
                <button
                    onClick={handleReGenerateTranscript}
                    disabled={loading}
                    className="re-generate-btn"
                >
                    {loading ? "Re-generating..." : "Re-generate Transcript"}
                </button>
            )}

            {message && <p className="message">{message}</p>}

            {improvedTranscript || transcript ? (
                <div className="transcript-container">
                    <h3>Transcript</h3>
                    <ReactMarkdown>
                        {improvedTranscript || transcript || "No transcript available."}
                    </ReactMarkdown>
                </div>
            ) : null}
        </div>
    );
}

export default UploadVideo;
