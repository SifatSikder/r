// Import necessary functions from Vue Router
import { createRouter, createWebHistory } from "vue-router";

// Import the main layout component
import Layout from "../pages/layout/layout.vue";

//=====================
// Pages
//=====================
import Dashboard from "../pages/dashboard/dashboard.vue";
import EvaluationReport from "../pages/evaluation/report.vue";
import Profile from "../pages/profile/profile.vue";
import ProfileUpdate from "../pages/profile/profile-update.vue";
import ProfilePasswordUpdate from "../pages/profile/profile-password-update.vue";

//=====================
// Routes
//=====================
const ROOT_URL = "/portal";
const routes = [
    // Portal
    {
        path: ROOT_URL, name: 'Layout', component: Layout,
        children: [
            { path: ROOT_URL + '/', redirect: { name: 'Dashboard' } },
            { path: ROOT_URL + '/dashboard', name: 'Dashboard', component: Dashboard },
            { path: ROOT_URL + '/profile', name: 'Profile', component: Profile },
            { path: ROOT_URL + '/profile/update', name: 'ProfileUpdate', component: ProfileUpdate },
            { path: ROOT_URL + '/profile/password/update', name: 'ProfilePasswordUpdate', component: ProfilePasswordUpdate },
            { path: ROOT_URL + '/ai/report/:evaluation_id', name: 'EvaluationReport', component: EvaluationReport },
        ]
    },
];

// Create router instance with history mode and defined routes
const router = createRouter({
    history: createWebHistory(),
    routes
});

// Export the router instance for use in other modules
export default router;
