import { Routes, Route } from 'react-router-dom';

import Layout from '@Pages/layout/Layout.jsx';
import Home from '@Pages/home/Home.jsx';
import NotFound from '@Pages/notFound/NotFound.jsx';

import AuthRouter from '@Routes/authentication.route';
import CourseRouter from '@Routes/course.route';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>
                <Route index element={<Home />} />
                <Route path="course/*" element={<CourseRouter />} />
                <Route path="auth/*" element={<AuthRouter />} />
                <Route path="*" element={<NotFound />} />
            </Route>
        </Routes>
    );
};

export default Router;
