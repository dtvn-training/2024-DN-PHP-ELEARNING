import { useState, useEffect } from 'react';
import './FeatureCard.css';

function FeatureCard() {
    const [features, setFeatures] = useState([]);

    useEffect(() => {
        const fetchFeatures = async () => {
            try {
                const response = await fetch('/data/featureInfo.json');
                const data = await response.json();
                setFeatures(data);
            } catch {
                setFeatures([]);
            }
        };

        fetchFeatures();
    }, []);

    return (
        <div className="info-features-container">
            {features.map((feature, index) => (
                <div key={index} className="info-feature-card">
                    <div className="info-icon" style={{ backgroundColor: feature.backgroundColor }}>
                        <img src={feature.iconSrc} alt={`${feature.title} Icon`} />
                    </div>
                    <h3 className="info-feature-title">{feature.title}</h3>
                    <p className="info-feature-description">{feature.description}</p>
                </div>
            ))}
        </div>
    );
}

export default FeatureCard;
