import { Routes, Route } from 'react-router-dom';

import ViewCourse from '@Pages/course/ViewCourse';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/:course_id" element={<ViewCourse />} />
        </Routes>
    );
};

export default CourseRouter;
