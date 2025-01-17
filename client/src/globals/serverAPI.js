import axios from 'axios';

const serverAPI = axios.create({
    baseURL: `${import.meta.env.VITE_SERVER_DOMAIN}/api`,
    withCredentials: true,
});

// The 'post' need a defaukt body {}
const originalPost = serverAPI.post;
serverAPI.post = (url, data = {}) => originalPost.call(serverAPI, url, data);

export default serverAPI;
