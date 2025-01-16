import { Routes, Route } from 'react-router-dom';

import ModifyCourse from '@Pages/course/ModifyCourse.jsx';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/:course_id/modify" element={<ModifyCourse />} />
        </Routes>
    );
};

export default CourseRouter;
