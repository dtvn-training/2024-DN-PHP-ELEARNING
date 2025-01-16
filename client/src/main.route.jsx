import { Routes, Route } from 'react-router-dom';

import Layout from '@Pages/layout/Layout.jsx';
import Home from '@Pages/home/Home.jsx';
import NotFound from '@Pages/notFound/NotFound.jsx';

import AuthRouter from '@Routes/authentication.route';
import LessonRouter from '@Routes/lesson.route';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>
                <Route index element={<Home />} />
                <Route path="auth/*" element={<AuthRouter />} />
                <Route path="course/:course_id/lesson/*" element={<LessonRouter />} />
                <Route path="*" element={<NotFound />} />
            </Route>
        </Routes>
    );
};

export default Router;
