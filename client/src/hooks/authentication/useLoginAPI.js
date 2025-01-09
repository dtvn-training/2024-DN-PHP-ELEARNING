import { useMutation } from "react-query";
import axios from "axios";

const fetchLogin = async ({ account, password }) => {
    try {
        const response = await axios.post(
            `${import.meta.env.VITE_SERVER_DOMAIN}/api/auth/login`,
            { account, password },
            { withCredentials: true }
        );
        
        if (response.status === 200) {
            return response.data;
        } else {
            throw new Error("Login failed: Unexpected response");
        }
    } catch (error) {
        throw new Error(error.response?.data?.message || "Login failed");
    }
};

const useLoginAPI = (onSuccess, onError) => {
    return useMutation(fetchLogin, {
        onSuccess,
        onError,
    });
};

export default useLoginAPI;
