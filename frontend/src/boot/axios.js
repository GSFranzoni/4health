import Vue from 'vue';
import axios from 'axios';
import Notification from '../util/Notification';
import { Loading } from 'quasar';

Vue.prototype.$axios = axios

axios.interceptors.request.use(async (config) => {
    Loading.show();
    return config;
});

axios.interceptors.response.use((response) => {
    Loading.hide();
    return response;
}, (error) => {
    Loading.hide();
    return Promise.reject(error);
});