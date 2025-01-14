import { Routes, Route } from 'react-router-dom';

import CoursesDashboard from '@Pages/course/coursesDashboard/CoursesDashboard.jsx';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/dashboard" element={<CoursesDashboard />} />
        </Routes>
    );
};

export default CourseRouter;
