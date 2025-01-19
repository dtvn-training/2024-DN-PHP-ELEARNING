import { Routes, Route } from 'react-router-dom';

import ViewCourse from '@Pages/course/ViewCourse';
import CreateCourse from '@Pages/course/CreateCourse';
import NotFound from '@Pages/notFound/NotFound.jsx';

const CourseRouter = () => {
    return (
        <Routes>
            <Route path="/create" element={<CreateCourse />} />
            <Route path="/:course_id/view" element={<ViewCourse />} />
            <Route path="*" element={<NotFound />} />
        </Routes>
    );
};

export default CourseRouter;
