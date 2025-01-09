// src/routes/authentication.route.jsx
import { Routes, Route } from 'react-router-dom';

import Login from '@Pages/authentication/Login.jsx';

const AuthenticationRouter = () => {
    return (
        <Routes>
            <Route path="login" element={<Login />} />
        </Routes>
    );
};

export default AuthenticationRouter;
