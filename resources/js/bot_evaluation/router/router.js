// Import necessary functions from Vue Router
import { createRouter, createWebHistory } from "vue-router";

//=====================
// Pages
//=====================
import DemoStart from "../pages/demo-start.vue";
import ProjectIntro from "../pages/project-intro.vue";
import AskAiSystems from "../pages/ask-ai-systems.vue";
import PlanningAiSystems from "../pages/planning-ai-systems.vue";
import BenefitAiSystems from "../pages/benefit-ai-systems.vue";
import TrainingAiSystems from "../pages/training-ai-systems.vue";
import SafetyRisksDomains from "../pages/safety-risks-domains.vue";
import fdQuestions from "../pages/fd-questions.vue";
import cgptQuestions from "../pages/cgpt-questions.vue";
import AlmostDone from "../pages/almost_done.vue";

//=====================
// Routes
//=====================
const ROOT_URL = "/bot-evaluation";
const routes = [

    // Pages
    { path: ROOT_URL + '/demo-start', name: 'DemoStart', component: DemoStart },
    { path: ROOT_URL + '/project-intro', name: 'ProjectIntro', component: ProjectIntro },
    { path: ROOT_URL + '/start-evaluation', name: 'AskAiSystems', component: AskAiSystems },
    { path: ROOT_URL + '/planning-for-ai', name: 'PlanningAiSystems', component: PlanningAiSystems },
    { path: ROOT_URL + '/benefit-of-ai', name: 'BenefitAiSystems', component: BenefitAiSystems },
    { path: ROOT_URL + '/training-of-ai', name: 'TrainingAiSystems', component: TrainingAiSystems },
    { path: ROOT_URL + '/safety-risks-domains', name: 'SafetyRisksDomains', component: SafetyRisksDomains },
    { path: ROOT_URL + '/fair-decision-questions', name: 'fdQuestions', component: fdQuestions },
    { path: ROOT_URL + '/chat-gpt-questions', name: 'cgptQuestions', component: cgptQuestions },
    { path: ROOT_URL + '/almost-done', name: 'AlmostDone', component: AlmostDone },
];

// Create router instance with history mode and defined routes
const router = createRouter({
    history: createWebHistory(),
    routes
});

// Export the router instance for use in other modules
export default router;
