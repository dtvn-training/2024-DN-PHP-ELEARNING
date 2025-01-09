import { Routes, Route } from 'react-router-dom';

import LoadingScene from '@Utilities/LoadingScene.jsx';
import ErrorScene from '@Utilities/ErrorScene.jsx';

const TestRouter = () => {
    return (
        <Routes>
            <Route path="loading" element={<LoadingScene />} />
            <Route path="error" element={<ErrorScene />} />
        </Routes>
    );
};

export default TestRouter ;
