import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchLogin = async ({ account, password }) => {
    try {
        const response = await serverAPI.post('auth/login', { account, password });
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
