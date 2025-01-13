import { Routes, Route } from 'react-router-dom';

import Layout from '@Pages/layout/Layout.jsx';
import Home from '@Pages/home/Home.jsx';
import NotFound from '@Pages/notFound/NotFound.jsx';

import TestRouter from '@Routes/test.route';
import AuthRouter from '@Routes/authentication.route';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>
                <Route index element={<Home />} />
                <Route path="test/*" element={<TestRouter />} />
                <Route path="auth/*" element={<AuthRouter />} />
                <Route path="*" element={<NotFound />} />
            </Route>
        </Routes>
    );
};

export default Router;
