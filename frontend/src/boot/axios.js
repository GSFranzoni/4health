import Vue from 'vue';
import axios from 'axios';
import { Loading } from 'quasar';

axios.defaults.baseURL = process.env.API.replaceAll("\"", "");

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