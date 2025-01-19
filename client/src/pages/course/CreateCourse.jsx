import { useState } from "react";
import useAddCourse from "@Hooks/course/useCreateCourse";
import LoadingScene from "@Utilities/LoadingScene";
import AuthProtect from "@Utilities/AuthProtect";
import CourseForm from "./CourseForm";
import DashboardLayout from "./DashboardLayout";
import "./CreateCourse.css";

const AddCourse = () => {
    const { mutate: addCourse, isLoading: isSaving, isError, error: saveError } = useAddCourse();
    const [isSuccess, setIsSuccess] = useState(false);

    const handleSubmit = (formData) => {
        addCourse(formData, {
            onSuccess: (data) => {
                window.location.href = `/course/${data}/modify`;
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
        <DashboardLayout>
            <AuthProtect isAuth={true} destination={'/auth/login'}>
                <div className="add-course-container">
                    <div className="add-course-content">
                        <h1 className="add-course-header">Add New Course</h1>
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
        </DashboardLayout>
    );
};

export default AddCourse;
