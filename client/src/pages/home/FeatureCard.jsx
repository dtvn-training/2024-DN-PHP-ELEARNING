import getFeaturesData from '@Hooks/useFeaturesData';
import LoadingScene from '@Utilities/LoadingScene.jsx';
import ErrorScene from '@Utilities/ErrorScene.jsx';
import './FeatureCard.css';

function FeatureCard() {
    const { data: features, isLoading, isError } = getFeaturesData();

    if (isLoading) {
        return <LoadingScene />;
    }

    if (isError) {
        return <ErrorScene />;
    }

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
