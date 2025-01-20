import React, { useState, useRef } from "react";
import useImproveTranscript from "@Hooks/material/useImproveTranscript";

const ImproveTranscript = ({ materialId, materialContent }) => {
    const { mutate: improveTranscriptMutation, isLoading } = useImproveTranscript();
    const [prompt, setPrompt] = useState("");

    const handlePromptChange = (event) => {
        setPrompt(event.target.value);
    };

    const handleImproveButtonClick = async () => {
        await improveTranscriptMutation({ materialId, materialContent, prompt });
    };

    return (
        <div className="improve-transcript-container">
            <div className="optional-prompt">
                <input
                    type="text"
                    placeholder="Enter an optional prompt for improvement"
                    value={prompt}
                    onChange={handlePromptChange}
                    className="prompt-input"
                    disabled={isLoading}
                />
            </div>
            <button
                type="button"
                className="improve-transcript-button"
                onClick={handleImproveButtonClick}
                disabled={isLoading}
            >
                {isLoading ? "Improving..." : "Improve Transcript"}
            </button>
        </div>
    );
};

export default ImproveTranscript;
