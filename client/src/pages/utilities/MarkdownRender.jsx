import React from 'react';
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import DOMPurify from 'dompurify';
import './MarkdownRender.css';

const MarkdownRender = ({ content }) => {
    return (
        <div className="markdown-render">
            <ReactMarkdown remarkPlugins={[remarkGfm]}>
                {DOMPurify.sanitize(content, { USE_PROFILES: { html: true } })}
            </ReactMarkdown>
        </div>
    );
};

export default MarkdownRender;
