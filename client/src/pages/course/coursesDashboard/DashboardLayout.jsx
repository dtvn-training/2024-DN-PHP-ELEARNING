import { Link } from "react-router-dom";
import useHighlightPage from "@Hooks/useHighlightPage";
import AuthProtect from "@Utilities/AuthProtect";
import './DashboardLayout.css';

const DashboardLayout = ({ children }) => {
    const navItems = {
        "manage-course-button": "/course/dashboard",
        "statistics-course-button": "/course/statistics",
    };

    useHighlightPage(navItems);

    return (
        <AuthProtect isAuth={true} destination={'/auth/login'}>
            <div className="dashboard-layout-container">
                <header className="dashboard-layout-content">
                    <div className="dashboard-header">
                        <ul className="course-manage-nav">
                            <li><Link to="/course/dashboard" id="manage-course-button">Dashboard</Link></li>
                            <li><Link to="/course/statistics" id="statistics-course-button">Course Statistics</Link></li>
                        </ul>
                    </div>
                </header>
                <main className="dashboard-content">
                    {children}
                </main>
            </div>
        </AuthProtect>
    );
};

export default DashboardLayout;
