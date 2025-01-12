import React from "react";
import "./EnsureMessage.css";

const EnsureMessage = ({ message, onConfirm, onCancel }) => {
    return (
        <div className="ensure-message-overlay">
            <div className="ensure-message-box">
                <p className="ensure-message-text">{message}</p>
                <div className="ensure-message-buttons">
                    <button className="ensure-message-yes" onClick={onConfirm}>
                        Yes
                    </button>
                    <button className="ensure-message-no" onClick={onCancel}>
                        No
                    </button>
                </div>
            </div>
        </div>
    );
};

export default EnsureMessage;
