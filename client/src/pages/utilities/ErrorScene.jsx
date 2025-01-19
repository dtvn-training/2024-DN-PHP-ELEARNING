import './ErrorScene.css';

function ErrorScene() {
    return (
        <div className="error-container">
            <div className="error-message">
                <h2>ERROR ON REQUEST!</h2>
                <p>Something went wrong. Please try again later.</p>
                <a href="/" className="go-home-button">Go to Home</a>
            </div>
        </div>
    );
}

export default ErrorScene;
