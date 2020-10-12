import Vue from 'vue';
import axios from 'axios';
import { Loading } from 'quasar';
import Notification from '../util/Notification';
import Store from '../store/index';
import Router from '../router/index';

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

    if (error.response.status === 401) {
        Notification.negative(error);
        Store.commit('logout');
        Router.push('/auth');
    }

    return Promise.reject(error);
});