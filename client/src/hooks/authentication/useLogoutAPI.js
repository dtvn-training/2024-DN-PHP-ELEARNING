import { useMutation } from "react-query";
import axios from "axios";

const fetchLogout = async () => {
    try {
        const response = await axios.post(
            `${import.meta.env.VITE_SERVER_DOMAIN}/api/auth/logout`,
            null,
            { withCredentials: true }
        );
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Logout failed");
    }
};

const useLogoutAPI = (onSuccess, onError) => {
    return useMutation(fetchLogout, {
        onSuccess,
        onError,
    });
};

export default useLogoutAPI;
