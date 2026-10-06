/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap';
import { createApp } from 'vue';
import DefaultComponent from "./components/DefaultComponent.vue";
import router from './router';
import store from './store';
import axios from 'axios';
import i18n from "./i18n";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueSimpleAlert from "vue3-simple-alert";
import VueNextSelect from 'vue-next-select';
import 'vue-next-select/dist/index.css';
import VueApexCharts from "vue3-apexcharts";
import ENV from './config/env';
import 'sweetalert2/dist/sweetalert2.min.css';
import 'swiper/css';



/* Start tooltip alert code */
const options = {
    timeout: 2000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false
};
/* End tooltip alert code */


/* Start axios code*/
const getBaseUrl = () => {
    if (typeof window !== 'undefined' && window.APP_URL) {
        return window.APP_URL.replace(/\/+$/, '');
    }
    if (ENV.API_URL) {
        return ENV.API_URL.replace(/\/+$/, '');
    }
    if (typeof window !== 'undefined' && window.location && window.location.origin) {
        return window.location.origin;
    }
    return '';
};

const getApiKey = () => {
    if (typeof window !== 'undefined' && window.APP_KEY) {
        return window.APP_KEY;
    }
    return ENV.API_KEY || '';
};

const baseUrl = getBaseUrl();
axios.defaults.baseURL = baseUrl ? (baseUrl + '/api') : '/api';

// Concurrency pool to prevent hitting shared hosting entry process limits (HTTP 508)
const MAX_CONCURRENT = 4;
let activeRequests = 0;
const requestQueue = [];

const processQueue = () => {
    while (activeRequests < MAX_CONCURRENT && requestQueue.length > 0) {
        activeRequests++;
        const { resolve } = requestQueue.shift();
        resolve();
    }
};

const releaseQueue = () => {
    activeRequests = Math.max(0, activeRequests - 1);
    processQueue();
};

axios.interceptors.request.use(
    config => {
        config.headers['x-api-key'] = getApiKey();
        if (typeof localStorage !== 'undefined' && localStorage.getItem('vuex')) {
            try {
                const vuex = JSON.parse(localStorage.getItem('vuex'));
                const token = vuex?.auth?.authToken;
                const language = vuex?.globalState?.lists?.language_code;
                if (token) {
                    config.headers['Authorization'] = `Bearer ${token}`;
                }
                if (language) {
                    config.headers['x-localization'] = language;
                }
            } catch (e) {
                // Ignore json parse error
            }
        }

        return new Promise(resolve => {
            requestQueue.push({ resolve: () => resolve(config) });
            processQueue();
        });
    },
    error => {
        releaseQueue();
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    response => {
        releaseQueue();
        return response;
    },
    async error => {
        releaseQueue();

        const config = error?.config;
        const status = error?.response?.status;

        // Auto retry on 508 (Loop Detected / Resource limit) or 429 once after 400ms delay
        if (config && (status === 508 || status === 429) && !config._retry508) {
            config._retry508 = true;
            await new Promise(r => setTimeout(r, 400));
            return axios(config);
        }

        return Promise.reject(error);
    }
);
/* End axios code */

const app = createApp({});
app.component('default-component', DefaultComponent);
app.component('vue-select', VueNextSelect)
app.use(router)
app.use(store)
app.use(VueSimpleAlert)
app.use(VueApexCharts)
app.use(Toast, options)
app.use(i18n)
app.mount('#app');
