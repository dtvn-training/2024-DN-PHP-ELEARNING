import { Routes, Route } from 'react-router-dom';

import CreateCourse from '@Pages/course/CreateCourse.jsx';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/create" element={<CreateCourse />} />
        </Routes>
    );
};

export default CourseRouter;
