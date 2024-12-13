import React, { useState } from "react";
import axios from "axios";
import ReactMarkdown from "react-markdown";
import "./UploadVideo.css";

function UploadVideo() {
    const [videoFile, setVideoFile] = useState(null);
    const [previewUrl, setPreviewUrl] = useState(null);
    const [language, setLanguage] = useState("en-US"); // Default language set to English
    const [transcript, setTranscript] = useState(null);
    const [improvedTranscript, setImprovedTranscript] = useState(null);
    const [uploadedVideoPath, setUploadedVideoPath] = useState(null);
    const [videoName, setVideoName] = useState(null);
    const [transcriptPath, setTranscriptPath] = useState(null);
    const [prompt, setPrompt] = useState("");
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState("");

    const MAX_FILE_SIZE = 100 * 1024 * 1024;

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
            setTranscript(null);
            setImprovedTranscript(null);
            setUploadedVideoPath(null);
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
            setUploadedVideoPath(videoPath);
            setVideoName(videoPath.split("/").pop());
        } catch (error) {
            setMessage(
                error.response?.data?.message ||
                "Error uploading video. Please try again."
            );
        } finally {
            setLoading(false);
        }
    };

    const fetchTranscript = async () => {
        setLoading(true);
        setMessage("Generating transcript...");

        try {
            const response = await axios.get(
                `http://localhost:8000/api/transcript?name=${videoName}&language=${language}`
            );

            setTranscript(response.data.transcript);
            setTranscriptPath(response.data.path);
            setMessage("Transcript generated successfully.");
        } catch (error) {
            setMessage(
                error.response?.data?.message ||
                "Error generating transcript. Please try again."
            );
        } finally {
            setLoading(false);
        }
    };

    const fetchImprovedTranscript = async () => {
        setLoading(true);
        setMessage("Improving transcript...");

        try {
            const sentPrompt = prompt?.trim() || prompt.trim() !== '' ?
                `Improve transcript, keep the origin language, ${prompt}`
                : `Improve the following text while maintaining the same length and depth as the original content. Keep the origin language,`;

            const response = await axios.get(
                `http://localhost:8000/api/transcript/improve?prompt=${encodeURIComponent(sentPrompt)}&path=${transcriptPath}`
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

            {previewUrl && !uploadedVideoPath && (
                <button onClick={handleUpload} disabled={loading}>
                    {loading ? "Processing..." : "Upload Video"}
                </button>
            )}

            {uploadedVideoPath && !transcript && (
                <>
                    <div className="language-dropdown">
                        <label htmlFor="language-select">Choose Language:</label>
                        <select
                            id="language-select"
                            value={language}
                            onChange={(e) => setLanguage(e.target.value)}
                        >
                            <option value="en-US">English</option>
                            <option value="vi-VN">Vietnamese</option>
                            <option value="es-ES">Spanish</option>
                            <option value="fr-FR">French</option>
                            <option value="de-DE">German</option>
                        </select>
                    </div>
                    <button onClick={fetchTranscript} disabled={loading}>
                        {loading ? "Processing..." : "Generate Transcript"}
                    </button>
                </>
            )}

            {transcript && (
                <>
                    <input
                        type="text"
                        placeholder="Enter prompt (optional)"
                        value={prompt}
                        onChange={(e) => setPrompt(e.target.value)}
                    />
                </>
            )}

            {transcript && !improvedTranscript && (
                <>
                    <button onClick={fetchImprovedTranscript} disabled={loading}>
                        {loading ? "Processing..." : "Improve Transcript"}
                    </button>
                </>
            )}

            {improvedTranscript && (
                <button onClick={fetchImprovedTranscript} disabled={loading}>
                    {loading ? "Re-improving..." : "Re-Improve Transcript"}
                </button>
            )}

            {message && <p className="message">{message}</p>}

            {(improvedTranscript || transcript) && (
                <div className="transcript-container">
                    <h3>Transcript</h3>
                    <ReactMarkdown>
                        {improvedTranscript || transcript || "No transcript available."}
                    </ReactMarkdown>
                </div>
            )}
        </div>
    );
}

export default UploadVideo;
