import { useLocation, useNavigate, Outlet } from 'react-router-dom';
import './Layout.css';

function Layout() {
    const navigate = useNavigate();

    return (
        <div className="layout-container">
            <header>
                <div className='header-content'>
                    <img
                        className='page-icon'
                        src='layout/icon-elearning-full.png'
                        alt='page icon'
                        onClick={() => navigate('/')}
                    />
                    <ul className='nav_bar'>
                        <li onClick={() => navigate('/')}>Home</li>
                        <li onClick={() => navigate('/courses')}>Courses</li>
                        <li onClick={() => navigate('/about')}>About</li>
                        <li onClick={() => navigate('/contact')}>Contact Us</li>
                        <li id='login-btn' onClick={() => navigate('/auth/login')}>Login</li>
                    </ul>
                </div>
            </header>

            <main>
                <Outlet />
                {/* All pages contain in ./pages will be render inside here */}
            </main>

            <footer>
                <div className="footer-container">
                    <div className="section-container">
                        <div className="footer-section">
                            <h4 className="footer-title">Contact Us</h4>
                            <img
                                className='footer-icon'
                                src='layout/icon-elearning-short.png'
                                alt='page icon'
                                onClick={() => navigate('/')}
                            />
                            <img
                                className='footer-icon'
                                src='layout/dac.png'
                                alt='page icon'
                                onClick={() => navigate('/')}
                            />
                        </div>
                        <div className="footer-section">
                            <h4 className="footer-title">Contact Us</h4>
                            <ul className="footer-list">
                                <li><i className="fas fa-map-marker-alt"></i>Spring Store London Oxford Street, 012 United Kingdom</li>
                                <li><i className="fas fa-phone-alt"></i>+84 395 075 100</li>
                                <li><i className="fas fa-envelope"></i>trinhquythien.dev@gmail.com</li>
                            </ul>
                        </div>

                        <div className="footer-section">
                            <h4 className="footer-title">Feature Links</h4>
                            <ul className="footer-list">
                                <li onClick={() => navigate('/')}>Home</li>
                                <li onClick={() => navigate('/courses')}>Courses</li>
                                <li onClick={() => navigate('/about')}>About</li>
                                <li onClick={() => navigate('/contact')}>Contact Us</li>
                            </ul>
                        </div>

                        <div className="footer-section">
                            <h4 className="footer-title">Support</h4>
                            <ul className="footer-list">
                                <li>FAQ's</li>
                                <li>Support</li>
                            </ul>
                        </div>
                    </div>

                    <div className="social-media">
                        <a href="#" className="social-btn facebook">Facebook</a>
                        <a href="#" className="social-btn linkedin">LinkedIn</a>
                    </div>

                    <div className="footer-bottom">
                        <p>Copyright © 2024 E-learning.</p>
                        <p>All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div >
    );
}

export default Layout;
