import { Routes, Route } from 'react-router-dom';

import ViewCourse from '@Pages/course/ViewCourse.jsx';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/info/:course_id" element={<ViewCourse />} />
        </Routes>
    );
};

export default CourseRouter;
