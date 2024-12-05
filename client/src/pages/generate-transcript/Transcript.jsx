import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';
import './Transcript.css';

function Transcript() {
    const { name } = useParams(); // Get the video name from the route parameter
    const [transcript, setTranscript] = useState('');
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        const fetchTranscript = async () => {
            try {
                const response = await axios.get(`http://localhost:8000/api/media/transcript?name=${name}`);
                setTranscript(response.data.transcript);
                setError('');
            } catch (err) {
                if (err.response && err.response.status === 404) {
                    setError('The specified video does not exist.');
                } else {
                    setError('An error occurred while fetching the transcript.');
                }
            } finally {
                setLoading(false);
            }
        };

        fetchTranscript();
    }, [name]);

    return (
        <div className="transcript-container">
            {loading && <p>Loading transcript...</p>}
            {!loading && error && <p className="error-message">{error}</p>}
            {!loading && !error && (
                <>
                    <h2>Transcript for {name}</h2>
                    <div className="transcript-content">
                        <p>{transcript}</p>
                    </div>
                </>
            )}
        </div>
    );
}

export default Transcript;
