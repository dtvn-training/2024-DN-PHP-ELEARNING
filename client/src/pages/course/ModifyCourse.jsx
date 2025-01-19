import { useState } from "react";
import { useParams, useNavigate, Link } from "react-router-dom";
import useCourseInfo from "@Hooks/course/useViewCourse";
import useModifyCourse from "@Hooks/course/useModifyCourse";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import AuthProtect from "@Utilities/AuthProtect";
import CourseForm from './CourseForm';
import DashboardLayout from "./DashboardLayout";
import ViewAllLesson from "@Pages/lesson/ViewAllLesson";
import './ModifyCourse.css'

const ModifyCourse = () => {
    const { course_id } = useParams();
    const { data, error, isLoading, refetch } = useCourseInfo(course_id);
    const { mutate: modifyCourse, isLoading: isSaving, isError, error: saveError } = useModifyCourse();
    const [isSuccess, setIsSuccess] = useState(false);

    const handleSubmit = (formData) => {
        modifyCourse(formData, {
            onSuccess: () => {
                setIsSuccess(true);
                refetch();
            },
            onError: () => {
                setIsSuccess(false);
                refetch();
            },
        });
    };

    if (error) {
        return <ErrorScene />;
    }

    if (isLoading || isSaving || !data) {
        return <LoadingScene />;
    }

    return (
        <DashboardLayout>
            <AuthProtect isAuth={true} destination={'/auth/login'}>
                <div className="modify-course-container">
                    <div className="modify-course-content">
                        <h1 className="modify-course-header">Modify Course</h1>
                        <Link to={`/course/${course_id}/view`} className="modify-course-link">Go to Course <strong>{data.course_name}</strong></Link>
                        <CourseForm
                            courseData={{
                                course_id: Number.parseInt(course_id),
                                course_name: data.course_name,
                                short_description: data.short_description,
                                long_description: data.long_description,
                                course_price: data.course_price,
                                course_duration: data.course_duration,
                                course_state: data.course_state,
                            }}
                            onSubmit={handleSubmit}
                            isSaving={isSaving}
                            isSuccess={isSuccess}
                            isError={isError}
                            saveError={saveError}
                        />
                        <ViewAllLesson course_id={course_id} />
                    </div>
                </div>
            </AuthProtect>
        </DashboardLayout>
    );
};

export default ModifyCourse;
