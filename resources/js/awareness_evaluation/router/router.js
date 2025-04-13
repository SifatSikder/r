// Import necessary functions from Vue Router
import { createRouter, createWebHistory } from "vue-router";

//=====================
// Pages
//=====================
import Home from "../pages/Home.vue";

//=====================
// Routes
//=====================
const ROOT_URL = "/awareness-evaluation";
const routes = [

    // Pages
    { path: ROOT_URL + '/:type', name: 'Home', component: Home },
];

// Create router instance with history mode and defined routes
const router = createRouter({
    history: createWebHistory(),
    routes
});

// Export the router instance for use in other modules
export default router;
