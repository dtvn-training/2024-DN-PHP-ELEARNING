import { useState } from "react";
import { useParams, Link } from "react-router-dom";
import useViewLesson from "@Hooks/lesson/useViewLesson";
import useModifyLesson from "@Hooks/lesson/useModifyLesson";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import AuthProtect from "@Utilities/AuthProtect";
import DashboardLayout from "@Pages/course/DashboardLayout";
import './ModifyLesson.css';

const ModifyLesson = () => {
    const { lesson_id } = useParams();
    const { data, error, isLoading, refetch } = useViewLesson(lesson_id);
    const { mutate: modifyLesson, isLoading: isSaving, isError, error: saveError } = useModifyLesson();
    const [lessonName, setLessonName] = useState(null);
    const [message, setMessage] = useState(null);

    const handleSubmit = (e) => {
        e.preventDefault();

        if (!lessonName && !data.lesson_name) {
            setMessage({ type: 'error', text: "Lesson name cannot be empty." });
            return;
        }

        setMessage(null);

        modifyLesson(
            { lesson_id, lesson_name: lessonName ?? data.lesson_name },
            {
                onSuccess: () => {
                    setMessage({ type: 'success', text: "Lesson updated successfully!" });
                    refetch();
                },
                onError: () => {
                    setMessage({ type: 'error', text: "Failed to update the lesson." });
                },
            }
        );
    };

    if (error) {
        return <ErrorScene />;
    }

    if (isLoading || isSaving) {
        return <LoadingScene />;
    }

    return (
        <DashboardLayout>
            <div className="modify-lesson-container">
                <div className="modify-lesson-content">
                    <Link to={`/course/${data.course_id}/modify`} className="modify-lesson-link">Back to Course Modify</Link>
                    <form onSubmit={handleSubmit} className="modify-lesson-form">
                        <label htmlFor="lesson-name" className="modify-lesson-label">
                            Lesson Name
                        </label>
                        <input
                            type="text"
                            id="lesson-name"
                            className="modify-lesson-input"
                            value={lessonName ?? data.lesson_name}
                            onChange={(e) => setLessonName(e.target.value)}
                        />
                        {isSaving && (
                            <div className="modify-lesson-message modify-lesson-loading">
                                Saving changes, please wait...
                            </div>
                        )}
                        <button
                            type="submit"
                            className="modify-lesson-button"
                            disabled={isSaving}
                        >
                            {isSaving ? "Saving..." : "Save Changes"}
                        </button>
                        {message && (
                            <div className={`modify-lesson-message ${message.type === 'error' ? 'modify-lesson-error' : 'modify-lesson-success'}`}>
                                {message.text}
                            </div>
                        )}
                    </form>
                </div>
            </div>
        </DashboardLayout>
    );
};

export default ModifyLesson;
