import { useQuery } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchAuthStatus = async () => {
    try {
        const response = await serverAPI.get('auth/status');
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
