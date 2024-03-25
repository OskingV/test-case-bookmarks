import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://localhost/api/', // Your API base URL
});

export default instance;
