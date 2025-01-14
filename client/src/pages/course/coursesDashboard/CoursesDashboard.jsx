import { Link, useNavigate } from 'react-router-dom';
import DashboardLayout from './DashboardLayout';
import useAllCoursesInfo from '@Hooks/course/useAllCoursesInfo';
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import './CoursesDashboard.css';

const CoursesDashboard = () => {
    const navigate = useNavigate();
    const { data: courses, isLoading, error } = useAllCoursesInfo();

    const handleDelete = (courseId) => {
        console.log(`Deleting course with ID: ${courseId}`);
    };

    if (isLoading) {
        return <LoadingScene />;
    }

    if (error) {
        return <ErrorScene />;
    }

    return (
        <DashboardLayout>
            <div className="courses-dashboard-container">
                <div className="courses-dashboard-content">
                    <button
                        className="course-add-button"
                        onClick={() => navigate(`/course/add`)}
                    >
                        Add Course
                    </button>
                    {(!courses || courses.length === 0) ? (
                        <p className="no-courses-message">You have no courses available! Click "Add Course" button above to adding your first course.</p>
                    ) : (
                        <ul className="courses-list">
                            {courses?.map(course => (
                                course.course_state === 1 && (
                                    <li key={course.course_id} className="course-item">
                                        <div className="course-info" onClick={() => navigate(`/course/info/${course.course_id}`)}>
                                            <div className='name-price-part'>
                                                <p className="course-name">{course.course_name}</p>
                                                <p className="course-price">{`${course.course_price.toLocaleString()} VND`}</p>
                                            </div>
                                            <div className='date-part'>
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
                                                onClick={() => navigate(`/course/edit/${course.course_id}`)}
                                            >
                                                Edit
                                            </button>
                                            <button
                                                className="course-delete-button"
                                                onClick={() => handleDelete(course.course_id)}
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </li>
                                )
                            ))}
                        </ul>
                    )}
                </div>
            </div>
        </DashboardLayout>
    );
};

export default CoursesDashboard;
