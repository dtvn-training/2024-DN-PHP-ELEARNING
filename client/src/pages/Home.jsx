import { useNavigate } from 'react-router-dom';
import './Home.css';

function Home() {
    const navigate = useNavigate();

    return (
        <div className="home-container">
            <div className='introduce-box'>
                <div className='introduce-box-left'>
                    <h4>Start Learning and Embrace New Skills For Better Future</h4>
                    <p>With the help of E-Learning, create your own path and drive on your skills on your own to achieve what you seek.</p>
                    <button onClick={() => navigate('/courses')}>View our courses</button>
                </div>
                <div className='introduce-box-right'>
                    <img src='home/table.png' alt='image' />
                </div>
            </div>

            <div className="information-box">
                <div className="info-wrapper">
                    <h4 className="info-title">Why Choose E-learning?</h4>
                    <p className="info-description">
                        Look into yourself, know you&apos;re ambitious and keep moving forward until
                        you get something in return as your achievement.
                    </p>

                    <div className="info-features-container">
                        <div className="info-feature-card">
                            <div className="info-icon" style={{ backgroundColor: "#e0ecff" }}>
                                <img src="home/accessibility-icon.png" alt="Course Accessibility Icon" />
                            </div>
                            <h3 className="info-feature-title">Course Accessibility</h3>
                            <p className="info-feature-description">
                                Select a suitable course from the vast area of other courses and
                                access it anytime and from anywhere.
                            </p>
                        </div>

                        <div className="info-feature-card">
                            <div className="info-icon" style={{ backgroundColor: "#dce7f9" }}>
                                <img src="home/scholarship-icon.png" alt="Scholarship Icon" />
                            </div>
                            <h3 className="info-feature-title">Scholarship</h3>
                            <p className="info-feature-description">
                                To encourage talent, we give up to 100% aid to those young learners
                                who have the ability to do something.
                            </p>
                        </div>

                        <div className="info-feature-card">
                            <div className="info-icon" style={{ backgroundColor: "#ffe4c2" }}>
                                <img src="home/learning-icon.png" alt="Practical Learning Icon" />
                            </div>
                            <h3 className="info-feature-title">Practical Learning</h3>
                            <p className="info-feature-description">
                                Interact yourself with the real-world while doing real-world projects
                                and other things to master your skills.
                            </p>
                        </div>

                        <div className="info-feature-card">
                            <div className="info-icon" style={{ backgroundColor: "#e9ffd8" }}>
                                <img src="home/expert-icon.png" alt="Expert Instructions Icon" />
                            </div>
                            <h3 className="info-feature-title">Expert Instructions</h3>
                            <p className="info-feature-description">
                                Hold the opportunity to learn from the industry&apos;s expert and learn
                                how to execute things like them.
                            </p>
                        </div>

                        <div className="info-feature-card">
                            <div className="info-icon" style={{ backgroundColor: "#efebff" }}>
                                <img src="home/schedule-icon.png" alt="Schedule Learning Icon" />
                            </div>
                            <h3 className="info-feature-title">Schedule Learning</h3>
                            <p className="info-feature-description">
                                Learn at whatever and whenever at your suitable time and place. Get a
                                part-time study degree.
                            </p>
                        </div>

                        <div className="info-feature-card">
                            <div className="info-icon" style={{ backgroundColor: "#ffd8df" }}>
                                <img src="home/material-icon.png" alt="Recorded Sessions Icon" />
                            </div>
                            <h3 className="info-feature-title">Multiple Learning Materials</h3>
                            <p className="info-feature-description">
                                Enhance your learning with interactive exercises, and now, 
                                text transcriptions of video lectures.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Home;
