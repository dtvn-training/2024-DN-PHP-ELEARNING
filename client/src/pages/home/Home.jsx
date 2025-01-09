import { useNavigate} from 'react-router-dom';
import FeatureCard from './FeatureCard';
import './Home.css';

function Home() {
    const navigate = useNavigate();

    const navigateToCourses = () => navigate('/courses');

    return (
        <div className="home-container">
            <div className="introduce-box">
                <div className="introduce-box-left">
                    <h4>Start Learning and Embrace New Skills For Better Future</h4>
                    <p>With the help of E-Learning, create your own path and drive on your skills on your own to achieve what you seek.</p>
                    <button type='button' aria-label='To courses' onClick={navigateToCourses}>View our courses</button>
                </div>
                <div className="introduce-box-right">
                    <img src="home/table.png" alt="image" />
                </div>
            </div>

            <div className="information-box">
                <div className="info-wrapper">
                    <h4 className="info-title">Why Choose E-learning?</h4>
                    <p className="info-description">
                        Look into yourself, know you&apos;re ambitious and keep moving forward until
                        you get something in return as your achievement.
                    </p>

                    <FeatureCard />
                </div>
            </div>
        </div>
    );
}

export default Home;
