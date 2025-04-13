import {createRouter, createWebHistory} from "vue-router";


//=====================
// Pages
//=====================
import JoinNow from "../pages/join-now.vue";
import JoinFairAnalysis from "../pages/join-fair-analysis.vue";
import Login from "../pages/login.vue";
import Register from "../pages/register.vue";

import ProjectIntro from "../pages/project-intro.vue";
import AskAiSystems from "../pages/ask-ai-systems.vue";
import PlanningAiSystems from "../pages/planning-ai-systems.vue";
import BenefitAiSystems from "../pages/benefit-ai-systems.vue";
import TrainingAiSystems from "../pages/training-ai-systems.vue";
import EtNt from "../pages/et-nt.vue";
import EtEta from "../pages/et-eta.vue";
import EtQuestions from "../pages/et-questions.vue";
import EtQuestionsDomain from "../pages/et-questions-domain.vue";
import EtaFdQuestions from "../pages/eta-fd-questions.vue";
import NtQuestions from "../pages/nt-questions.vue";
import fdQuestions from "../pages/fd-questions.vue";

import SafetyRisksDomains from "../pages/safety-risks-domains.vue";
import AiSystems from "../pages/ai-systems.vue";
import AiSystemFeedback from "../pages/ai-system-feedback.vue";
import AlmostDone from "../pages/almost_done.vue";

//=====================
// Routes
//=====================
const ROOT_URL = "/risk-evaluation";
const routes = [

    // Pages
    {path: ROOT_URL + '/join-now', name: 'JoinNow', component: JoinNow},
    {path: ROOT_URL + '/join-fair-analysis', name: 'JoinFairAnalysis', component: JoinFairAnalysis},
    {path: ROOT_URL + '/login', name: 'Login', component: Login},
    {path: ROOT_URL + '/register', name: 'Register', component: Register},

    {path: ROOT_URL + '/project-intro', name: 'ProjectIntro', component: ProjectIntro},
    {path: ROOT_URL + '/start-evaluation', name: 'AskAiSystems', component: AskAiSystems},
    {path: ROOT_URL + '/planning-for-ai', name: 'PlanningAiSystems', component: PlanningAiSystems},
    {path: ROOT_URL + '/benefit-of-ai', name: 'BenefitAiSystems', component: BenefitAiSystems},
    {path: ROOT_URL + '/training-of-ai', name: 'TrainingAiSystems', component: TrainingAiSystems},
    {path: ROOT_URL + '/et-nt', name: 'EtNt', component: EtNt},
    {path: ROOT_URL + '/et-eta', name: 'EtEta', component: EtEta},

    {path: ROOT_URL + '/safety-risks-domains', name: 'SafetyRisksDomains', component: SafetyRisksDomains},
    {path: ROOT_URL + '/eta-questions/:domain', name: 'EtQuestionsDomain', component: EtQuestionsDomain},
    {path: ROOT_URL + '/eta-fd-questions/:domain', name: 'EtaFdQuestions', component: EtaFdQuestions},
    {path: ROOT_URL + '/et-questions', name: 'EtQuestions', component: EtQuestions},
    {path: ROOT_URL + '/nt-questions', name: 'NtQuestions', component: NtQuestions},
    {path: ROOT_URL + '/fd-questions', name: 'fdQuestions', component: fdQuestions},

    // {path: ROOT_URL + '/ai-systems', name: 'AiSystems', component: AiSystems},
    // {path: ROOT_URL + '/ai-system-feedback', name: 'AiSystemFeedback', component: AiSystemFeedback},

    {path: ROOT_URL + '/almost-done', name: 'AlmostDone', component: AlmostDone},
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
