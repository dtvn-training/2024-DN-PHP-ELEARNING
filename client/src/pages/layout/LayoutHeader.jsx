import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import './LayoutHeader.css';

const LayoutHeader = () => {
    const [menuOpen, setMenuOpen] = useState(false);
    const navigate = useNavigate();

    const navigateToHome = () => navigate('/');

    const toggleMenu = () => {
        setMenuOpen((prev) => {
            const isMenuOpen = !prev;
            document.body.style.overflow = isMenuOpen ? "hidden" : "scroll";
            return isMenuOpen;
        });
    };

    return (
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
                    onClick={toggleMenu}
                />
                {menuOpen && <div className="overlay" onClick={toggleMenu}></div>}
                <nav className={`nav-bar ${menuOpen ? 'open' : ''}`} onClick={() => menuOpen ? toggleMenu() : null}>
                    <ul>
                        <li><Link to='/'>Home</Link></li>
                        <li><Link to='/courses'>Courses</Link></li>
                        <li><Link to='/about'>About</Link></li>
                        <li><Link to='/contact'>Contact Us</Link></li>
                        <li><Link to='/auth/login' id='login-btn'>Login</Link></li>
                    </ul>
                </nav>
            </div>
        </header>
    );
};

export default LayoutHeader;
