// src/Router.jsx
import { Routes, Route } from 'react-router-dom';

import Layout from './pages/layout/Layout.jsx';
import Home from './pages/home/Home.jsx';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>
                <Route index element={<Home />} />
            </Route>
        </Routes>
    );
};

export default Router;
