// src/Router.jsx
import { Routes, Route } from 'react-router-dom';

import Layout from './pages/Layout.jsx';
import Home from './pages/Home.jsx';

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
