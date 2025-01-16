import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import MarkdownRender from "@Utilities/MarkdownRender";
import useCourseInfo from "@Hooks/course/useViewCourse";
import './ViewCourse.css';

const ViewCourse = () => {
    const { course_id } = useParams();
    const { data, error, isLoading } = useCourseInfo(course_id);
    const [isCourseFound, setIsCourseFound] = useState(true);
    const navigate = useNavigate();

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
        long_description,
        course_price,
        course_duration,
        user_first_name,
        user_last_name,
        user_email,
        user_phone_number,
        user_address,
    } = data;

    const formattedPrice = new Intl.NumberFormat('en-GB').format(course_price);

    return (
        <div className="course-container">
            <div className="course_information">
                <div className="info-part">
                    <h1 className="course-title">{course_name}</h1>
                    <div className="enroll head">
                        <p><strong>Duration: </strong>{course_duration}</p>
                        <p><strong>Price: </strong>{formattedPrice} VND</p>
                        <button type="button" onClick={() => navigate(`/course/enroll/${course_id}`)}>Enroll now </button>
                    </div>
                    <div className="long-description">
                        <MarkdownRender content={long_description} />
                    </div>
                </div>
                <div className="enroll-part">
                    <img src="/home/table.png" alt="course" />
                    <div className="provider-information">
                        <h3 className="table-title">Information</h3>
                        <table>
                            <tbody>
                                <tr><td><strong>Duration:</strong></td><td>{course_duration}</td></tr>
                                <tr><td><strong>Price:</strong></td><td>{formattedPrice} VND</td></tr>
                                <tr><td><strong>Provided by:</strong></td><td>{user_first_name} {user_last_name}</td></tr>
                                <tr><td><strong>Contact:</strong></td><td>{user_email}</td></tr>
                                <tr><td></td><td>{user_phone_number}</td></tr>
                                <tr><td></td><td>{user_address}</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div className="enroll">
                        <button type="button" onClick={() => navigate(`/course/enroll/${course_id}`)}>Enroll now</button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ViewCourse;
