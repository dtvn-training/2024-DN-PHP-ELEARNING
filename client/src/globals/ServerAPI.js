import axios from "axios";

// Create Axios instance
const serverAPI = axios.create({
    baseURL: `${import.meta.env.VITE_SERVER_DOMAIN}/api`,
    withCredentials: true,
});

serverAPI.interceptors.request.use(
    async (config) => {
        if (!document.cookie.includes("XSRF-TOKEN")) {
            await axios.get(`${import.meta.env.VITE_SERVER_DOMAIN}/sanctum/csrf-cookie`, {
                withCredentials: true,
            });
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default serverAPI;
