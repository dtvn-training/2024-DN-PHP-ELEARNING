import { Outlet } from 'react-router-dom';
import './Layout.css';

function Layout() {
    return (
        <div className="layout-container">
            <header>
                {/* Header here, implement navbar, sidebar, etc. */}
            </header>

            <main>
                <Outlet />
                {/* All pages contain in ./pages will be render inside here */}
            </main>

            <footer>
                {/* Footer */}
            </footer>
        </div>
    );
}

export default Layout;
