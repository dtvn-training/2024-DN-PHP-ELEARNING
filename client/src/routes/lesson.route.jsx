import { Routes, Route } from 'react-router-dom';

import ModifyLesson from '@Pages/lesson/ModifyLesson.jsx';
import NotFound from '@Pages/notFound/NotFound.jsx';

const LessonRouter = () => {
    return (
        <Routes>
            <Route path="/:lesson_id/modify" element={<ModifyLesson />} />
            <Route path="*" element={<NotFound />} />
        </Routes>
    );
};

export default LessonRouter;
