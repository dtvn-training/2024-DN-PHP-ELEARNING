import { Routes, Route } from 'react-router-dom';

import CoursesDashboard from '@Pages/course/coursesDashboard/CoursesDashboard.jsx';
import ViewCourse from '@Pages/course/ViewCourse.jsx';
import AddCourse from '@Pages/course/AddCourse.jsx';
import ModifyCourse from '@Pages/course/ModifyCourse.jsx';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/dashboard" element={<CoursesDashboard />} />
            <Route path="/info/:course_id" element={<ViewCourse />} />
            <Route path="/add" element={<AddCourse />} />
            <Route path="/modify/:course_id" element={<ModifyCourse />} />
        </Routes>
    );
};

export default CourseRouter;
