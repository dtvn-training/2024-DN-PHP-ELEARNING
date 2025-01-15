import { Routes, Route } from 'react-router-dom';

import CoursesDashboard from '@Pages/course/coursesDashboard/CoursesDashboard.jsx';
import ViewCourse from '@Pages/course/ViewCourse.jsx';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/dashboard" element={<CoursesDashboard />} />
            <Route path="/info/:course_id" element={<ViewCourse />} />
        </Routes>
    );
};

export default CourseRouter;
