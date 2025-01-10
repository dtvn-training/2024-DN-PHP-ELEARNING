import { useMutation } from "react-query";
import axios from "axios";

const fetchLogin = async ({ account, password }) => {
    try {
        const response = await axios.post(
            `${import.meta.env.VITE_SERVER_DOMAIN}/api/auth/login`,
            { account, password },
            { withCredentials: true }
        );
        return {
            data: response.data,
            status: response.status
        };
    } catch (error) {
        return {
            data: error.response?.data?.message || "Login failed",
            status: error.response?.status || 500
        };
    }
};

const useLoginAPI = (onSuccess, onError) => {
    return useMutation(fetchLogin, {
        onSuccess,
        onError,
    });
};

export default useLoginAPI;
