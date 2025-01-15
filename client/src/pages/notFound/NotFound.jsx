import './NotFound.css';

const NotFound = () => {
    return (
        <div className='not-found-container'>
            <div className='not-found-content'>
                <img src='/layout/notFound.png' />

                <div className='not-found-noti'>
                    <span>
                        <a href='/'>Back to home</a>
                        &nbsp;right now. If something went wrong,&nbsp;
                        <a href='/feedback'>report for us</a>.
                    </span>
                    <p className='qoute'>
                        &quot;Education is the most powerful weapon which you can use to change the world.&quot;
                    </p>
                    <p className='great-man'>
                        &mdash; Nelson Mandela
                    </p>
                    <p className='joke'>
                        <span>
                            But even education couldn&apos;t prepare us for this missing page.
                            &nbsp;<a href='/'>Let's do it again.</a>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    );
}

export default NotFound;
