import { useQuery } from "react-query";
import axios from "axios";

const fetchAuthStatus = async () => {
    try {
        const response = await axios.get(
            `${import.meta.env.VITE_SERVER_DOMAIN}/api/auth/status`,
            { withCredentials: true }
        );
        return response.data;
    } catch (error) {
        throw new Error(error.response?.data?.message || "Failed to fetch authentication status");
    }
};

const useAuthStatusAPI = () => {
    return useQuery("authStatus", fetchAuthStatus, {
        retry: false,
        onError: (error) => {
            console.error("Authentication Error:", error.message);
        },
    });
};

export default useAuthStatusAPI;
