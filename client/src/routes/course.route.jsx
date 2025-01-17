import { Routes, Route } from 'react-router-dom';

import ViewCourse from '@Pages/course/ViewCourse';
import CoursesDashboard from '@Pages/course/CoursesDashboard.jsx';
import ModifyCourse from '@Pages/course/ModifyCourse.jsx';
import CreateCourse from '@Pages/course/CreateCourse.jsx';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/:course_id/view" element={<ViewCourse />} />
            <Route path="/dashboard" element={<CoursesDashboard />} />
            <Route path="/:course_id/modify" element={<ModifyCourse />} />
            <Route path="/create" element={<CreateCourse />} />
        </Routes>
    );
};

export default CourseRouter;
