import { BrowserRouter } from 'react-router-dom';
import { createRoot } from 'react-dom/client';
import './main.css';

import Router from './main.route.jsx';

createRoot(document.getElementById('root')).render(
    <BrowserRouter>
        <Router />
    </BrowserRouter>
);
