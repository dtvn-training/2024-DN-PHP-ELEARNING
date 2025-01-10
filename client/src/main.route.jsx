import { Routes, Route } from 'react-router-dom';

import Layout from '@Pages/layout/Layout.jsx';
import Home from '@Pages/home/Home.jsx';

import TestRouter from '@Routes/test.route';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>
                <Route index element={<Home />} />
                <Route path="test/*" element={<TestRouter />} />
            </Route>
        </Routes>
    );
};

export default Router;
