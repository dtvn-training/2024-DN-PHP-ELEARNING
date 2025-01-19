import React, { useState } from "react";
import useGenerateTranscript from "@Hooks/material/useGenerateTranscript";

const GenerateTranscript = ({ materialId, materialContent }) => {
    const { mutate: generateTranscriptMutation, isLoading } = useGenerateTranscript();

    const handleGenerateButtonClick = async () => {
        await generateTranscriptMutation({ materialId, materialContent });
    };

    return (
        <div>
            <button
                type="button"
                className="generate-transcript-button"
                onClick={handleGenerateButtonClick}
                disabled={isLoading}
            >
                {isLoading ? "Generating..." : "Generate Transcript"}
            </button>
        </div>
    );
};

export default GenerateTranscript;
