import './NotFound.css';

const NotFound = () => {
    return (
        <div className='not-found-container'>
            <div className='not-found-noti'>
                <h1>Oops!</h1>
                <h2>PAGE NOT FOUND!</h2>
                <h3>Error code: 404</h3>
                <a href='/'>Back to home</a>
            </div>
        </div>
    );
}

export default NotFound;
