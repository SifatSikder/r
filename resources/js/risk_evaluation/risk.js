
/*
* *******************************************************************
*  Bootstrap
* *******************************************************************
* */
import jQuery from "jquery";
const $ = jQuery;
window.$ = $;

import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.js'
window.bootstrap = bootstrap

import axios from "axios";


import App from "./App.vue";
import {createApp} from "vue";
import router from "./router/router";

import VueSweetAlert from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

createApp(App)
    .use(router, axios, VueSweetAlert)
    .mount('#app')
