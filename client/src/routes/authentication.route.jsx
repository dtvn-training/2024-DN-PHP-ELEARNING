import { Routes, Route } from 'react-router-dom';

import Login from '@Pages/authentication/Login.jsx';
import Logout from '@Pages/authentication/Logout.jsx';

const AuthenticationRouter = () => {
    return (
        <Routes>
            <Route path="login" element={<Login />} />
            <Route path="logout" element={<Logout />} />
        </Routes>
    );
};

export default AuthenticationRouter;
