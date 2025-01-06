import { useNavigate } from 'react-router-dom';
import './LayoutFooter.css';

const LayoutFooter = () => {
    const navigate = useNavigate();

    return (
        <footer>
            <div className="footer-container">
                <div className="section-container">
                    {/* Contact Section */}
                    <div className="footer-section">
                        <h4 className="footer-title">Contact Us</h4>
                        <img
                            className="footer-icon"
                            src="/layout/icon-elearning-short.png"
                            alt="E-learning short logo"
                            onClick={() => navigate('/')}
                        />
                        <img
                            className="footer-icon"
                            src="/layout/dac.png"
                            alt="DAC logo"
                            onClick={() =>
                                window.location.href = 'https://dac-datatech.vn/'
                            }
                        />
                    </div>

                    {/* Contact Information Section */}
                    <div className="footer-section">
                        <h4 className="footer-title">Contact Information</h4>
                        <ul className="footer-list">
                            <li className="footer-address">
                                <a
                                    href="https://maps.app.goo.gl/DzodKexyk4qZfiFq9"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    3rd floor, Eden Plaza DaNang Building,
                                    No. 5-7 Duy Tan Street, Hoa Thuan Dong Ward,
                                    Hai Chau District, Da Nang City, Vietnam
                                </a>
                            </li>
                            <li className="footer-phone">
                                <a href="tel:+84395075100">+84 395 075 100</a>
                            </li>
                            <li className="footer-mail">
                                <a
                                    href="mailto:trinhquythien.dev@gmail.com"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    trinhquythien.dev@gmail.com
                                </a>
                            </li>
                        </ul>
                    </div>

                    {/* Feature Links Section */}
                    <div className="footer-section">
                        <h4 className="footer-title">Feature Links</h4>
                        <ul className="footer-list">
                            <li><a href="/">Home</a></li>
                            <li><a href="/courses">Courses</a></li>
                            <li><a href="/about">About Us</a></li>
                            <li><a href="/contact">Contact</a></li>
                        </ul>
                    </div>

                    {/* Support Section */}
                    <div className="footer-section">
                        <h4 className="footer-title">Support</h4>
                        <ul className="footer-list">
                            <li><a href="/">FAQ&apos;s</a></li>
                            <li><a href="/">Support</a></li>
                        </ul>
                    </div>
                </div>

                {/* Social Media Links */}
                <div className="social-media">
                    <a
                        href="https://facebook.com/qthien1612"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="social-btn facebook"
                    >
                        Facebook
                    </a>
                    <a
                        href="https://www.linkedin.com/in/qthiendev/"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="social-btn linkedin"
                    >
                        LinkedIn
                    </a>
                </div>

                {/* Footer Bottom */}
                <div className="footer-bottom">
                    <p>&copy; 2024 E-learning by Trinh Quy Thien. All rights reserved.</p>
                </div>
            </div>
        </footer>
    );

};

export default LayoutFooter;