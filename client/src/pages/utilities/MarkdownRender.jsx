import React, { useEffect } from 'react';
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import DOMPurify from 'dompurify';
import './MarkdownRender.css';

const MarkdownRender = ({ content }) => {
    const handleMouseEnter = (e) => {
        e.target.style.cursor = 'pointer';
    };

    const handleCopy = (e) => {
        const text = e.target.innerText || e.target.textContent;
        navigator.clipboard.writeText(text)
            .then(() => {
                const alertMessage = document.createElement('div');
                alertMessage.textContent = 'Copied to clipboard!';
                alertMessage.classList.add('custom-alert');
                document.body.appendChild(alertMessage);
                alertMessage.style.position = 'fixed';
                alertMessage.style.top = '10px';
                alertMessage.style.left = '50%';
                alertMessage.style.transform = 'translateX(-50%)';
                setTimeout(() => {
                    document.body.removeChild(alertMessage);
                }, 2000);
            })
            .catch((err) => console.error('Error copying text: ', err));
    };

    useEffect(() => {
        const preElements = document.querySelectorAll('.markdown-render pre');
        preElements.forEach((pre) => {
            pre.addEventListener('click', handleCopy);
            pre.addEventListener('mouseenter', handleMouseEnter);
        });

        return () => {
            preElements.forEach((pre) => {
                pre.removeEventListener('click', handleCopy);
                pre.removeEventListener('mouseenter', handleMouseEnter);
            });
        };
    }, []);

    return (
        <div className="markdown-render">
            <ReactMarkdown remarkPlugins={[remarkGfm]}>
                {DOMPurify.sanitize(content, { USE_PROFILES: { html: true } })}
            </ReactMarkdown>
        </div>
    );
};

export default MarkdownRender;
