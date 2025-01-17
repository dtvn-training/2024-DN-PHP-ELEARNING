import { BrowserRouter } from 'react-router-dom';
import { createRoot } from 'react-dom/client';
import './main.css';

import Router from './main.route.jsx';
import { QueryClient, QueryClientProvider } from 'react-query';

const queryClient = new QueryClient();

createRoot(document.getElementById('root')).render(
    <QueryClientProvider client={queryClient}>
        <BrowserRouter>
            <Router />
        </BrowserRouter>
    </QueryClientProvider>
);
