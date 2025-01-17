import { Routes, Route } from 'react-router-dom';

import ViewAllLesson from '@Pages/lesson/ViewAllLesson.jsx';
import ModifyLesson from '@Pages/lesson/ModifyLesson.jsx';

const LessonRouter = () => {
    return (
        <Routes>
            <Route path="" element={<ViewAllLesson />} />
            <Route path="/:lesson_id/modify" element={<ModifyLesson />} />
        </Routes>
    );
};

export default LessonRouter;
