// Import jQuery and assign it to $ globally
import jQuery from "jquery";
const $ = jQuery;
window.$ = $;

// Import Bootstrap and assign it to the global window object
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.js'
window.bootstrap = bootstrap

// Import Axios for making HTTP requests
import axios from "axios";

// Import the main Vue app component and create the app instance
import App from "./App.vue";
import { createApp } from "vue";
import router from "./router/router";

// Import VueSweetAlert for displaying sweet alerts
import VueSweetAlert from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

// Create and mount the Vue app instance with necessary plugins
createApp(App)
    .use(router, axios, VueSweetAlert)
    .mount('#app')
