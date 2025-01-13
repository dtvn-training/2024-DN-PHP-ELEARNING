import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import useAuthStatusAPI from "@Hooks/authentication/useAuthStatusAPI";
import useAuthStore from '@Store/useAuthStore';
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";

const AuthProtect = ({ isAuth = true, destination = '/', children }) => {
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
        setAuthenticated(authStatus?.authenticated);
        navigate(isAuth !== authStatus?.authenticated ? destination : '');
        setAuthChecked(true);
    };

    useEffect(() => {
        if (!isLoading && !error && !authChecked) checkAuth();
    }, [isLoading, error, authChecked]);

    if (error) {
        return <ErrorScene />;
    }

    if (isLoading || !authChecked) {
        return <LoadingScene />;
    }

    return <>{children}</>;
};

export default AuthProtect;
