import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import useAuthStatusAPI from "@Hooks/authentication/useAuthStatusAPI";
import useAuthStore from '@Store/useAuthStore';
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";

const AuthProtect = ({ isAuth = true, children }) => {
    const { setAuthenticated } = useAuthStore();
    const navigate = useNavigate();
    const [authChecked, setAuthChecked] = useState(false);

    const {
        data: authStatus,
        isLoading,
        refetch,
        error
    } = useAuthStatusAPI();

    const checkAuth = async () => {
        await refetch();
        if (authStatus?.authenticated) {
            setAuthenticated(true);
            if (!isAuth) navigate('/'); // Requires unauthenticated access
        } else {
            setAuthenticated(false);
            if (isAuth) navigate('/'); // Requires authenticated access
        }
        setAuthChecked(true);
    };

    useEffect(() => {
        if (!isLoading && !error && !authChecked) checkAuth();
    }, [isLoading, error, authChecked]);

    if (isLoading || !authChecked) {
        return <LoadingScene />;
    }

    if (error) {
        return <ErrorScene />;
    }

    return <>{children}</>;
};

export default AuthProtect;
