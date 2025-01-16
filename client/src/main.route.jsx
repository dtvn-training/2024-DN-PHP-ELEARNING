import { Routes, Route } from 'react-router-dom';

import Layout from '@Pages/layout/Layout';
import Home from '@Pages/home/Home';

import AuthRouter from '@Routes/authentication.route';
import CourseRouter from '@Routes/course.route';
import NotFound from "./pages/notfound/NotFound";

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
