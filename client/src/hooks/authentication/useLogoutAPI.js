import { useMutation } from "react-query";
import serverAPI from "@Globals/serverAPI";

const fetchLogout = async () => {
    const response = await serverAPI.post('auth/logout');
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

