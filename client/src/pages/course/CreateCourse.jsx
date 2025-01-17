import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import useAddCourse from "@Hooks/course/useCreateCourse";
import LoadingScene from "@Utilities/LoadingScene";
import AuthProtect from "@Utilities/AuthProtect";
import CourseForm from "./forms/CourseForm";
import "./CreateCourse.css";

const AddCourse = () => {
    const { mutate: addCourse, isLoading: isSaving, isError, error: saveError } = useAddCourse();
    const [isSuccess, setIsSuccess] = useState(false);

    const handleSubmit = (formData) => {
        addCourse(formData, {
            onSuccess: (data) => {
                window.location.href = `/course/modify/${data}`;
            },
            onError: () => {
                setIsSuccess(false);
            },
        });
    };

    if (isSaving) {
        return <LoadingScene />;
    }

    return (
        <AuthProtect isAuth={true} destination={'/auth/login'}>
            <div className="add-course-container">
                <div className="add-course-content">
                    <h1 className="add-course-header">Add New Course</h1>
                    <Link to="/course/dashboard" className="add-course-link">
                        Back to Dashboard
                    </Link>
                    <CourseForm
                        courseData={{
                            course_name: "",
                            short_description: "",
                            long_description: "",
                            course_price: 0,
                            course_duration: "",
                            course_state: true,
                        }}
                        onSubmit={handleSubmit}
                        isSaving={isSaving}
                        isSuccess={isSuccess}
                        isError={isError}
                        saveError={saveError}
                    />
                </div>
            </div>
        </AuthProtect>
    );
};

export default AddCourse;
