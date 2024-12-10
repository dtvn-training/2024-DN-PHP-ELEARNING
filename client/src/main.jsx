import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { createRoot } from 'react-dom/client';
import './main.css';

import Layout from './Layout.jsx';

// Import page here
import UploadVideo from './pages/generate-transcript/UploadVideo.jsx';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>

                {/* Import page with route here */}
                <Route path="video/upload" element={<UploadVideo />} />

            </Route>
        </Routes>
    );
};

createRoot(document.getElementById('root')).render(
    <BrowserRouter>
        <Router />
    </BrowserRouter>
);
