// src/main.route.jsx
import { Routes, Route } from 'react-router-dom';

import Layout from './pages/Layout.jsx';
import Home from './pages/Home.jsx';

import AuthenticationRouter from './routes/authentication.route.jsx';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>
                <Route index element={<Home />} />
                <Route path="auth/*" element={<AuthenticationRouter />} />
            </Route>
        </Routes>
    );
};

export default Router;
