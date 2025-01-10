import { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import useLogoutAPI from "@Hooks/authentication/useLogoutAPI";
import useAuthStore from "@Store/useAuthStore";

const Logout = () => {
    const navigate = useNavigate();
    const { authenticated, setAuthenticated } = useAuthStore();

    const { mutate: logout, error } = useLogoutAPI(
        async () => {
            setAuthenticated(false);
            navigate("/auth/login");
        },
        async (error) => {
            if (error === 401) {
                setAuthenticated(false);
                navigate("/auth/login");
            }
        }
    );
    
    useEffect(() => {
        if (authenticated) {
            logout();
        } else {
            navigate('/auth/login');
        }
    }, [navigate, authenticated, logout]);

    if (error) {
        return <ErrorScene />;
    }

    return <LoadingScene />;
};

export default Logout;
