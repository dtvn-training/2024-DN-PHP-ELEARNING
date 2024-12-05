import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { createRoot } from 'react-dom/client';
import './main.css';

import Layout from './Layout.jsx';

// Import page here
import UploadVideo from './pages/generate-transcript/UploadVideo.jsx';
import Transcript from './pages/generate-transcript/Transcript.jsx';

const Router = () => {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>

                {/* Import page with route here */}
                <Route path="video/upload" element={<UploadVideo />} />
                <Route path="video/transcript/:name" element={<Transcript />} />

            </Route>
        </Routes>
    );
};

createRoot(document.getElementById('root')).render(
    <BrowserRouter>
        <Router />
    </BrowserRouter>
);
