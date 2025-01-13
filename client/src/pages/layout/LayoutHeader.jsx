import { useState, useEffect } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import useHighlightPage from '@Hooks/useHighlightPage';
import useAuthStore from '@Store/useAuthStore';
import SubMenu from './SubMenu';
import './LayoutHeader.css';

const LayoutHeader = () => {
    const [menuOpen, setMenuOpen] = useState(false);
    const [subMenuOpen, setSubMenuOpen] = useState(false);

    const { authenticated } = useAuthStore();

    const navigate = useNavigate();

    const navItems = {
        'home-btn': '/',
        'courses-btn': '/courses',
        'about-btn': '/about',
        'contact-btn': '/contact',
        'login-btn': '/auth/login',
    };

    useHighlightPage(navItems);

    const navigateToHome = () => navigate('/');

    const openMenu = () => setMenuOpen(true);
    const closeMenu = () => setMenuOpen(false);

    const openSubmenu = () => setSubMenuOpen(true);
    const closeSubmenu = () => setSubMenuOpen(false);

    const handleOverlayClick = () => {
        closeSubmenu(); closeMenu();
    };

    useEffect(() => {
        if (window.innerWidth <= 780)
        document.body.style.overflow = (menuOpen || subMenuOpen) ? 'hidden' : 'scroll';
    }, [menuOpen, subMenuOpen]);

    return (
        <>
            <header>
                <div className='header-content'>
                    <button
                        className='image-button-homepage'
                        type='button'
                        onClick={navigateToHome}
                        aria-label='Navbar home button'
                    />
                    <button
                        className='image-button-menu-toggle'
                        type='button'
                        aria-label='Menu toggle'
                        onClick={openMenu}
                    />
                    {(menuOpen || subMenuOpen) && <div className='overlay' onClick={handleOverlayClick}></div>}
                    <nav className={`nav-bar ${menuOpen ? 'open' : ''}`}>
                        <ul onClick={closeMenu}>
                            <li><Link to='/' id='home-btn'>Home</Link></li>
                            <li><Link to='/courses' id='courses-btn'>Courses</Link></li>
                            <li><Link to='/about' id='about-btn'>About</Link></li>
                            <li><Link to='/contact' id='contact-btn'>Contact Us</Link></li>
                            <li>
                                {authenticated ? (
                                    <button
                                        className='profile-button'
                                        aria-label='Profile button'
                                        onClick={subMenuOpen ? closeSubmenu : openSubmenu}
                                    >
                                        <img src='/layout/icon-user.png' alt='Profile' className='profile-image' />
                                    </button>
                                ) : (
                                    <Link to='/auth/login' id='login-btn'>Login</Link>
                                )}
                            </li>
                        </ul>
                    </nav>
                </div>
            </header>
            <SubMenu subMenuOpen={subMenuOpen} openMenu={openMenu} closeSubmenu={closeSubmenu} />
        </>
    );
};

export default LayoutHeader;
