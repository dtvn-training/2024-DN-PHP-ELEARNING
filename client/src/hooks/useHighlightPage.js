import { useEffect } from 'react';

const useHighlightPage = (navItems) => {
    useEffect(() => {
        const currentPath = window.location.pathname;

        Object.entries(navItems).forEach(([id, path]) => {
            const element = document.getElementById(id);
            if (element) {
                if (path === currentPath) {
                    element.classList.add('highlight-this');
                } else {
                    element.classList.remove('highlight-this');
                }
            }
        });
    }, [navItems]);
};

export default useHighlightPage;
