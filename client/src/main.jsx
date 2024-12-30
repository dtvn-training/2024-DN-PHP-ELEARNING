import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { createRoot } from 'react-dom/client';
import './main.css';

import Layout from './Layout.jsx';

import Login from './pages/authentication/Login.jsx';

// Import page here

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>

                <Route path='auth/login' element={<Login />}></Route>

            </Route>
        </Routes>
    );
};

createRoot(document.getElementById('root')).render(
    <BrowserRouter>
        <Router />
    </BrowserRouter>
);
