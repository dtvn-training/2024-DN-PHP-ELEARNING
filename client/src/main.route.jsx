import { Routes, Route } from 'react-router-dom';

import Layout from '@Pages/layout/Layout';
import Home from '@Pages/home/Home';
import NotFound from '@Pages/notFound/NotFound';

import AuthRouter from '@Routes/authentication.route';
import CourseRouter from '@Routes/course.route';
import LessonRouter from '@Routes/lesson.route';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>
                <Route index element={<Home />} />
                <Route path="course/*" element={<CourseRouter />} />
                <Route path="auth/*" element={<AuthRouter />} />
                <Route path="course/:course_id/lesson/*" element={<LessonRouter />} />
                <Route path="*" element={<NotFound />} />
            </Route>
        </Routes>
    );
};

export default Router;
