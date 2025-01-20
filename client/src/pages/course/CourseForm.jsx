import { useState, useEffect } from "react";
import MarkdownEditor from "@Utilities/MarkdownEditor";
import './CourseForm.css';

const CourseForm = ({ courseData = {}, onSubmit, isSaving, isSuccess, isError, saveError, refetch }) => {
    const [formData, setFormData] = useState({
        course_name: '',
        short_description: '',
        long_description: '',
        course_price: '',
        course_duration: '',
        course_state: '',
        ...courseData,
    });

    useEffect(() => {
        if (courseData) {
            setFormData(prev => ({
                ...prev,
                ...courseData
            }));
        }
    }, [courseData]);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

    const handleLongDescriptionChange = (newContent) => {
        setFormData((prev) => ({
            ...prev,
            long_description: newContent,
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(formData);
    };

    return (
        <div className="course-form-container">
            <form className="course-form" onSubmit={handleSubmit}>
                <label>
                    Course Name:
                    <input
                        type="text"
                        name="course_name"
                        value={formData.course_name}
                        onChange={handleInputChange}
                        required
                    />
                </label>
                <div className="price-duration">
                    <label>
                        Price (VND):
                        <input
                            type="number"
                            name="course_price"
                            value={formData.course_price}
                            onChange={handleInputChange}
                            required
                        />
                    </label>
                    <label>
                        Duration:
                        <input
                            type="text"
                            name="course_duration"
                            value={formData.course_duration}
                            onChange={handleInputChange}
                            required
                        />
                    </label>
                </div>
                <label>
                    Short Description:
                    <textarea
                        className="short_description_txt"
                        name="short_description"
                        value={formData.short_description}
                        onChange={handleInputChange}
                        required
                    />
                </label>
                <label>
                    Long Description:
                    <MarkdownEditor
                        className="long_description_txt"
                        name="long_description"
                        content={formData.long_description}
                        setContent={handleLongDescriptionChange}
                    />
                </label>
                {isSuccess && (
                    <p className="success-message">Successfully!</p>
                )}
                {isError && (
                    <p className="error-message">
                        {saveError?.message || "An error occurred. Please try again."}
                    </p>
                )}
                <div className="button-group">
                    <button type="submit">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    );
};

export default CourseForm;
