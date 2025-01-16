import { Routes, Route } from 'react-router-dom';

import ViewCourse from '@Pages/course/ViewCourse';
import CoursesDashboard from '@Pages/course/CoursesDashboard.jsx';
import ModifyCourse from '@Pages/course/ModifyCourse.jsx';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/view/:course_id" element={<ViewCourse />} />
            <Route path="/dashboard" element={<CoursesDashboard />} />
            <Route path="/modify/:course_id" element={<ModifyCourse />} />
        </Routes>
    );
};

export default CourseRouter;
