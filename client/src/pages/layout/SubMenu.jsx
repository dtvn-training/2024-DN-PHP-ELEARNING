import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import useHighlightPage from "@Hooks/useHighlightPage";
import EnsureMessage from "@Utilities/EnsureMessage";
import "./SubMenu.css";

const SubMenu = ({ subMenuOpen, openMenu, closeSubmenu }) => {
    const [showEnsureMessage, setShowEnsureMessage] = useState(false);
    const navigate = useNavigate();

    const navItems = {
        "profile-btn": "/profile",
        "learning-btn": "/learning",
        "manage-course-btn": "/course/dashboard",
    };

    useHighlightPage(navItems);

    const handleLogout = () => {
        setShowEnsureMessage(true);
    };

    const confirmLogout = () => {
        setShowEnsureMessage(false);
        navigate("/auth/logout");
    };

    const cancelLogout = () => {
        setShowEnsureMessage(false);
    };

    return (
        <>
            <div className={`sub-menu ${subMenuOpen ? "open" : ""}`}>
                <ul className="sub-menu-nav" onClick={closeSubmenu}>
                    <li><Link to="/profile" id="profile-btn">Profile</Link></li>
                    <li><Link to="/learning" id="learning-btn">Learning</Link></li>
                    <li><Link to="/course/dashboard" id="manage-course-btn">Manage Courses</Link></li>
                    <li><Link to="" id="logout-btn" onClick={handleLogout}>Logout</Link></li>
                    <li id="back-btn" onClick={openMenu}>&#x2190;</li>
                </ul>
            </div>
            {showEnsureMessage && (
                <EnsureMessage message="Are you sure you want to logout?"
                    onConfirm={confirmLogout}
                    onCancel={cancelLogout}
                />
            )}
        </>
    );
};

export default SubMenu;
