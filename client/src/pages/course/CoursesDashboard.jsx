import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import DashboardLayout from "./DashboardLayout";
import useAllCoursesInfo from "@Hooks/course/useAllCoursesInfo";
import useDeleteCourse from "@Hooks/course/useDeleteCourse";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import EnsureMessage from "@Utilities/EnsureMessage";
import "./CoursesDashboard.css";

const CoursesDashboard = () => {
    const navigate = useNavigate();
    const { data: courses, isLoading, error, refetch } = useAllCoursesInfo();
    const { mutate: deleteCourse, isLoading: loadingDelete } = useDeleteCourse();
    const [courseToDelete, setCourseToDelete] = useState(null);
    const [message, setMessage] = useState(null);

    const handleDelete = (courseId) => {
        setCourseToDelete(courseId);
    };

    const confirmDelete = () => {
        if (courseToDelete) {
            deleteCourse(
                { course_id: courseToDelete },
                {
                    onSuccess: () => {
                        setMessage({ type: "success", text: "Course deleted successfully!" });
                        setCourseToDelete(null);
                        refetch();
                    },
                    onError: () => {
                        setMessage({ type: "error", text: "Failed to delete course. Please try again." });
                        setCourseToDelete(null);
                    },
                }
            );
        }
    };

    const cancelDelete = () => {
        setCourseToDelete(null);
    };

    if (error) {
        return (
            <DashboardLayout>
                <ErrorScene />;
            </DashboardLayout>
        );
    }

    if (isLoading || loadingDelete) {
        return (
            <DashboardLayout>
                <LoadingScene />
            </DashboardLayout>
        );
    }

    return (
        <DashboardLayout>
            <div className="courses-dashboard-container">
                <div className="courses-dashboard-content">
                    <button
                        className="course-add-button"
                        onClick={() => navigate(`/course/create`)}
                    >
                        <img className="course-icon" src="/course/icon-add.png" />
                        Add Course
                    </button>
                    {message && (
                        <div className={`message ${message.type}`}>
                            {message.text}
                        </div>
                    )}
                    {(!courses || courses.length === 0) ? (
                        <p className="no-courses-message">
                            You have no courses available! Click "Add Course" button above to adding your first course.
                        </p>
                    ) : (
                        <ul className="courses-list">
                            {courses?.map((course) => (
                                course.course_state === 1 && (
                                    <li key={course.course_id} className="course-item">
                                        <div className="course-info" onClick={() => navigate(`/course/view/${course.course_id}`)}>
                                            <div className="name-price-part">
                                                <p className="course-name">{course.course_name}</p>
                                                <p className="course-price">{`${course.course_price.toLocaleString()} VND`}</p>
                                            </div>
                                            <div className="date-part">
                                                <p className="course-created-at">
                                                    Created date: {new Date(course.created_at).toLocaleDateString()}
                                                </p>
                                                <p className="course-updated-at">
                                                    Last Updated: {new Date(course.updated_at).toLocaleDateString()}
                                                </p>
                                            </div>
                                        </div>
                                        <div className="course-actions">
                                            <button
                                                className="course-edit-button"
                                                onClick={() => navigate(`/course/modify/${course.course_id}`)}
                                            >
                                                <img className="course-icon" src="/course/icon-edit.png" />
                                            </button>
                                            <button
                                                className="course-delete-button"
                                                onClick={() => { handleDelete(course.course_id) }}
                                            >
                                                <img className="course-icon" src="/course/icon-delete.png" />
                                            </button>
                                        </div>
                                    </li>
                                )
                            ))}
                        </ul>
                    )}
                </div>
            </div>
            {courseToDelete && (
                <EnsureMessage
                    message="Are you sure you want to delete this course?"
                    onConfirm={confirmDelete}
                    onCancel={cancelDelete}
                />
            )}
        </DashboardLayout>
    );
};

export default CoursesDashboard;
