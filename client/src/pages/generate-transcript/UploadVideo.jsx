import React, { useState } from 'react';
import axios from 'axios';
import './UploadVideo.css';

function UploadVideo() {
    const [videoFile, setVideoFile] = useState(null);
    const [previewUrl, setPreviewUrl] = useState(null);
    const [message, setMessage] = useState('');
    const [loading, setLoading] = useState(false);

    const handleFileChange = (event) => {
        const file = event.target.files[0];
        setVideoFile(file);
        // Create a preview URL for the video
        setPreviewUrl(URL.createObjectURL(file));
    };

    const handleUpload = async () => {
        if (!videoFile) {
            setMessage('Please select a video file.');
            return;
        }

        const formData = new FormData();
        formData.append('video', videoFile);

        setLoading(true);
        setMessage('');

        try {
            const response = await axios.post('http://localhost:8000/api/media/upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            
            setMessage('Video uploaded successfully!');
        } catch (error) {
            if (error.response) {
                setMessage(error.response.data.message || 'Error uploading video.');
            } else if (error.request) {
                setMessage('No response from server.');
            } else {
                setMessage('Error: ' + error.message);
            }
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
                {loading ? 'Uploading...' : 'Upload Video'}
            </button>
            {message && <p className="message">{message}</p>}
        </div>
    );
}

export default UploadVideo;
