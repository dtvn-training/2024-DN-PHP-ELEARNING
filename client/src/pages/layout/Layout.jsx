import {  Outlet } from 'react-router-dom';
import './Layout.css';

import LayoutHeader from './LayoutHeader';
import LayoutFooter from './LayoutFooter';

const Layout = () => {
    return (
        <div className="layout-container">
            <LayoutHeader />
            <main>
                <Outlet />
            </main>
            <LayoutFooter />
        </div>
    );
};

export default Layout;
