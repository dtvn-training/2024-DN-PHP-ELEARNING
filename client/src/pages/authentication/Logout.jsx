import { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import useLogoutAPI from "@Hooks/authentication/useLogoutAPI";
import LoadingScene from "@Utilities/LoadingScene";
import ErrorScene from "@Utilities/ErrorScene";
import useAuthStore from '@Store/useAuthStore';

const Logout = () => {
    const navigate = useNavigate();
    const { authenticated, setAuthenticated } = useAuthStore();

    const { mutate: logout, isLoading: loadingLogout, error } = useLogoutAPI(
        () => {
            setAuthenticated(false);
            navigate("/login");
        },
        (error) => {
            console.error("Logout failed:", error.message);
        }
    );

    useEffect(() => {
        if (!authenticated) {
            navigate("/");
        } else {
            logout();
        }
    }, [authenticated, logout, navigate]);

    if (error) {
        return <ErrorScene message="Logout failed, please try again." />;
    }

    return <LoadingScene />;
};

export default Logout;
