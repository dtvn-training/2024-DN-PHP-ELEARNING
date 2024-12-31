import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { createRoot } from 'react-dom/client';
import './main.css';

import Layout from './Layout.jsx';
import Home from './pages/Home.jsx';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>

                <Route path="/" element={<Home />} />

            </Route>
        </Routes>
    );
};

createRoot(document.getElementById('root')).render(
    <BrowserRouter>
        <Router />
    </BrowserRouter>
);
