import { useMutation } from "react-query";
import axios from "axios";

const fetchLogout = async () => {
    const response = await axios.post(
        `${import.meta.env.VITE_SERVER_DOMAIN}/api/auth/logout`,
        null,
        { withCredentials: true }
    );
    return response;
};

const useLogoutAPI = (onSuccess, onError) => {
    return useMutation(fetchLogout, {
        onSuccess,
        onError: (error) => {
            const status = error.response?.status || 500;
            onError(status);
        },
    });
};

export default useLogoutAPI;

