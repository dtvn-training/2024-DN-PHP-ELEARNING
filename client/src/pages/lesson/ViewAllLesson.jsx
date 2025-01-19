import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import useListLesson from "@Hooks/lesson/useListLesson";
import useCreateLesson from "@Hooks/lesson/useCreateLesson";
import useDeleteLesson from "@Hooks/lesson/useDeleteLesson";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import EnsureMessage from "@Utilities/EnsureMessage";
import "./ViewAllLesson.css";

const ViewAllLesson = ({ course_id }) => {
    const navigate = useNavigate();
    const { data: lessons, isLoading, error, refetch } = useListLesson(course_id);
    const { mutate: createLesson, isLoading: loadingAdd } = useCreateLesson();
    const { mutate: deleteLesson, isLoading: loadingDelete } = useDeleteLesson();

    const [lessonToDelete, setLessonToDelete] = useState(null);
    const [message, setMessage] = useState(null);

    const handleCreateLesson = () => {
        createLesson(
            { course_id, lesson_name: "New Lesson" },
            {
                onSuccess: () => {
                    setMessage({ type: "success", text: "Lesson added successfully!" });
                    refetch();
                },
                onError: (error) => {
                    setMessage({ type: "error", text: error?.message || "Failed to add lesson. Please try again." });
                },
            }
        );
    };

    const handleDelete = (lessonId) => {
        setLessonToDelete(lessonId);
    };

    const confirmDelete = () => {
        if (!lessonToDelete) return;

        deleteLesson(
            { lesson_id: lessonToDelete },
            {
                onSuccess: () => {
                    setMessage({ type: "success", text: "Lesson deleted successfully!" });
                    setLessonToDelete(null);
                    refetch();
                },
                onError: (error) => {
                    setMessage({ type: "error", text: error?.message || "Failed to delete lesson. Please try again." });
                    setLessonToDelete(null);
                },
            }
        );
    };

    const cancelDelete = () => {
        setLessonToDelete(null);
    };

    if (error) return <ErrorScene />;
    if (isLoading || loadingAdd || loadingDelete) return <LoadingScene />;

    return (
        <div className="lessons-dashboard-container">
            <div className="lessons-dashboard-content">
                <button
                    type="button"
                    className="lesson-add-button"
                    onClick={handleCreateLesson}
                >
                    <img className="lesson-icon" src="/course/icon-add.png" alt="Add Lesson" />
                    Add Lesson
                </button>

                {message && (
                    <div className={`message ${message.type}`}>
                        {message.text}
                    </div>
                )}

                <ul className="lessons-list">
                    {lessons.map((lesson) => (
                        <li key={lesson.lesson_id} className="lesson-item">
                            <div className="lesson-info">
                                <div className="name-part">
                                    <p className="lesson-name">{lesson.lesson_name}</p>
                                </div>
                                <div className="date-part">
                                    <p className="lesson-created-at">
                                        Created date: {new Date(lesson.created_at).toLocaleDateString()}
                                    </p>
                                    <p className="lesson-updated-at">
                                        Last Updated: {new Date(lesson.updated_at).toLocaleDateString()}
                                    </p>
                                </div>
                            </div>
                            <div className="lesson-actions">
                                <button
                                    type="button"
                                    className="lesson-edit-button"
                                    onClick={() => navigate(`/lesson/${lesson.lesson_id}/modify`)}
                                >
                                    <img className="lesson-icon" src="/course/icon-edit.png" alt="Edit" />
                                </button>
                                <button
                                    type="button"
                                    className="lesson-delete-button"
                                    onClick={() => handleDelete(lesson.lesson_id)}
                                >
                                    <img className="lesson-icon" src="/course/icon-delete.png" alt="Delete" />
                                </button>
                            </div>
                        </li>
                    ))}
                </ul>
            </div>

            {lessonToDelete && (
                <EnsureMessage
                    message="Are you sure you want to delete this lesson?"
                    onConfirm={confirmDelete}
                    onCancel={cancelDelete}
                />
            )}
        </div>
    );
};

export default ViewAllLesson;
