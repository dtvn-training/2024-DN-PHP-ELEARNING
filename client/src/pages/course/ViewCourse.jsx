import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import useCourseInfo from "@Hooks/course/useCourseInfo";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import './ViewCourse.css';

const ViewCourse = () => {
    const { course_id } = useParams();
    const { data, error, isLoading } = useCourseInfo(course_id);
    const [isCourseFound, setIsCourseFound] = useState(true);

    useEffect(() => {
        if (error?.message === "Course not found") {
            setIsCourseFound(false);
        }
    }, [error]);

    if (isLoading) {
        return <LoadingScene />;
    }

    if (!isCourseFound || error) {
        return <ErrorScene />;
    }

    const {
        course_name,
        course_description,
        course_price,
        user_first_name,
        user_last_name,
        user_email,
        user_phone_number,
        user_address,
    } = data;

    return (
        <div className="course-container">
            <div className="course_information">
                <div className="course-details">
                    <div className="course-part">
                        <div className="info-part">
                        <h1>{course_name}</h1>
                            <p>{course_description}</p>
                        </div> 
                        <img src="/home/table.png" />
                    </div>
                    <div className="provider-info">
                        <table>
                            <tbody>
                                <tr><td><strong>Provider Information:</strong></td><td>{user_first_name} {user_last_name}</td></tr>
                                <tr><td /><td>{user_email}</td></tr>
                                <tr><td /><td>{user_phone_number}</td></tr>
                                <tr><td /><td>{user_address}</td></tr>
                            </tbody>
                        </table>
                        <p><strong>Price:</strong> ${course_price}</p>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ViewCourse;
