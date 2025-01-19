import React, { useState, useRef } from 'react';
import MarkdownRender from "@Utilities/MarkdownRender";
import './MarkdownEditor.css';

const MarkdownEditor = ({ className, name, content, setContent }) => {
    const [editorContent, setEditorContent] = useState(content);
    const [viewMode, setViewMode] = useState('editor');
    const undoStack = useRef([]);
    const redoStack = useRef([]);
    
    const saveToUndoStack = (content) => {
        undoStack.current.push(content);
        redoStack.current = [];
    };

    const wrapTextWithMarkdown = (syntax) => {
        const textarea = document.getElementById(name);
        const selectionStart = textarea.selectionStart;
        const selectionEnd = textarea.selectionEnd;
        const selectedText = textarea.value.slice(selectionStart, selectionEnd);

        if (selectedText) {
            const newContent = `${textarea.value.slice(0, selectionStart)}${syntax.open}${selectedText}${syntax.close}${textarea.value.slice(selectionEnd)}`;
            setEditorContent(newContent);
            setContent(newContent);
            saveToUndoStack(newContent);
        }
    };

    const handleBoldText = () => wrapTextWithMarkdown({ open: '**', close: '**' });
    const handleItalicText = () => wrapTextWithMarkdown({ open: '*', close: '*' });
    const handleCodeText = () => wrapTextWithMarkdown({ open: '```bash\n', close: '\n```' });
    const handleQuoteText = () => wrapTextWithMarkdown({ open: '> ', close: '' });
    const handleH1Text = () => wrapTextWithMarkdown({ open: '# ', close: '' });
    const handleH2Text = () => wrapTextWithMarkdown({ open: '## ', close: '' });
    const handleH3Text = () => wrapTextWithMarkdown({ open: '### ', close: '' });

    const toggleViewMode = () => {
        setViewMode(viewMode === 'editor' ? 'preview' : 'editor');
    };

    return (
        <>
            <div className="markdown-toolbar">
                <button type="button" onClick={handleH1Text}><img className='md-button' src='/md/h1.svg'/></button>
                <button type="button" onClick={handleH2Text}><img className='md-button'src='/md/h2.svg'/></button>
                <button type="button" onClick={handleH3Text}><img className='md-button' src='/md/h3.svg'/></button>
                <button type="button" onClick={handleBoldText}><img className='md-button' src='/md/bold.png'/></button>
                <button type="button" onClick={handleItalicText}><img className='md-button' src='/md/italic.png'/></button>
                <button type="button" onClick={handleCodeText}><img className='md-button' src='/md/code.png'/></button>
                <button type="button" onClick={handleQuoteText}><img className='md-button' src='/md/qoute.png'/></button>
                <button type="button" onClick={toggleViewMode}>
                    {viewMode === 'editor' ? 'Preview' : 'Edit'}
                </button>
            </div>

            {viewMode === 'editor' ? (
                <textarea
                    id={name}
                    className={className}
                    name={name}
                    value={editorContent}
                    onChange={(e) => {
                        setEditorContent(e.target.value);
                        setContent(e.target.value);
                        saveToUndoStack(e.target.value);
                    }}
                    required
                />
            ) : (
                <div className="markdown-preview">
                    <MarkdownRender content={editorContent} />
                </div>
            )}
        </>
    );
};

export default MarkdownEditor;
