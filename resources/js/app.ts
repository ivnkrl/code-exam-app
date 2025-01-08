import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import axios from 'axios';

const options = {
    position: "top-right",
    timeout: 3000,
    closeOnClick: true,
    pauseOnHover: true,
    draggable: true,
};

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
axios.defaults.withCredentials = true;

const app = createApp(App);
app.use(Toast, options);
app.use(router);
app.mount('#app');