import { useState } from "react";
import { useParams, Link } from "react-router-dom";
import useViewLesson from "@Hooks/lesson/useViewLesson";
import useModifyLesson from "@Hooks/lesson/useModifyLesson";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import AuthProtect from "@Utilities/AuthProtect";
import MaterialDashboard from '@Pages/material/MaterialDashboard.jsx';
import './ModifyLesson.css';

const ModifyLesson = () => {
    const { course_id, lesson_id } = useParams();
    const { mutate: modifyLesson, isLoading: isSaving, isError, error: saveError } = useModifyLesson();
    const [lessonName, setLessonName] = useState(null);
    const [message, setMessage] = useState(null); // New state for the message

    const { data, error, isLoading, refetch } = useViewLesson(course_id, lesson_id);

    const handleSubmit = (e) => {
        e.preventDefault();

        if (!lessonName && !data.lesson_name) {
            setMessage({ type: 'error', text: "Lesson name cannot be empty." });
            return;
        }

        setMessage(null);

        modifyLesson(
            { course_id, lesson_id, lesson_name: lessonName ?? data.lesson_name },
            {
                onSuccess: () => {
                    setMessage({ type: 'success', text: "Lesson updated successfully!" });
                    refetch(); // Refresh data after modification
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

    if (isLoading || isSaving || !data) {
        return <LoadingScene />;
    }

    return (
        <AuthProtect isAuth={true} destination={'/auth/login'}>
            <div className="modify-lesson-container">
                <div className="modify-lesson-content">
                    <Link to={`/course/${course_id}/modify`} className="modify-lesson-link">Back to Course Modify</Link>
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
                    <MaterialDashboard course_id={course_id} lesson_id={lesson_id} />
                </div>
            </div>
        </AuthProtect>
    );
};

export default ModifyLesson;
