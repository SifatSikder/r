// Import jQuery and assign it to the global variable
import jQuery from "jquery";
const $ = jQuery;
window.$ = $;

// Import Bootstrap JavaScript and assign it to the global variable
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.js';
window.bootstrap = bootstrap;

// Import Axios for HTTP requests
import axios from "axios";

// Import the main App component and Vue
import App from "./App.vue";
import { createApp } from "vue";

// Import Vue Router for navigation
import router from "./router/router";

// Import VueSweetAlert for alert messages
import VueSweetAlert from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// Create the Vue app instance and mount it to the #app element
createApp(App)
    .use(router, axios, VueSweetAlert)
    .mount('#app');
