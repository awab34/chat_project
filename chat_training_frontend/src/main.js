import './assets/main.css'
import './assets/style.css';
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import * as Vue from 'vue' 
import axios from 'axios'
import VueAxios from 'vue-axios'
import store from './store/index.js';
import { createToast } from 'mosha-vue-toastify';
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
const app = Vue.createApp(App)

app.use(router)
//console.log(store.user);
app.use(VueAxios, axios)
app.use(store)
app.mount('#app')


export const $toast = useToast();

