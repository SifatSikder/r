import { createRouter, createWebHistory } from "vue-router";

// Importing layout and page components
import Layout from "../pages/layout/layout.vue";
import Login from "../pages/auth/login.vue";
import Dashboard from "../pages/dashboard/dashboard.vue";
import RiskFactors from "../pages/evaluation/risk-factors.vue";
import Sectors from "../pages/evaluation/sectors.vue";
import FdSectors from "../pages/evaluation/fd-sectors.vue";
import cgptQuestionnaires from "../pages/Questionnaires/cgptQuestionnaires.vue";
import ntQuestionnaires from "../pages/Questionnaires/ntQuestionnaires.vue";
import etQuestionnaires from "../pages/Questionnaires/etQuestionnaires.vue";
import etaQuestionnaires from "../pages/Questionnaires/etaQuestionnaires.vue";
import fdQuestionnaires from "../pages/Questionnaires/fdQuestionnaires.vue";
import etaFdQuestionnaires from "../pages/Questionnaires/etaFdQuestionnaires.vue";

import Awareness from "../pages/awareness/Awareness.vue";
import AwarenessCreate from "../pages/awareness/AwarenessCreate.vue";
import AwarenessEdit from "../pages/awareness/AwarenessEdit.vue";
import AwarenessPreview from "../pages/awareness/AwarenessPreview.vue";
import LessonCreate from "../pages/awareness/lessons/LessonCreate.vue";
import LessonEdit from "../pages/awareness/lessons/LessonEdit.vue";
import LessonPreview from "../pages/awareness/lessons/LessonPreview.vue";

import AwarenessLearnerTeacher from "../pages/awareness/learner-teacher/AwarenessLearnerTeacher.vue";

import WebHomeSettings from "../pages/WebsiteSettings/page_home_settings.vue";
import WebSafetySettings from "../pages/WebsiteSettings/page_safety_settings.vue";
import WebEvaluationSettings from "../pages/WebsiteSettings/page_evaluation_settings.vue";
import WebFairDecisionSettings from "../pages/WebsiteSettings/page_fd_settings.vue";
import WebTrainingSettings from "../pages/WebsiteSettings/page_training_settings.vue";
import WebAwarenessSettings from "../pages/WebsiteSettings/page_awareness_settings.vue";
import WebCertificationSettings from "../pages/WebsiteSettings/page_certification_settings.vue";
import WebTeamSettings from "../pages/WebsiteSettings/page_team_settings.vue";
import WebMetaSettings from "../pages/WebsiteSettings/meta_settings.vue";
import WebContactSettings from "../pages/WebsiteSettings/contact_settings.vue";
import WebSocialSettings from "../pages/WebsiteSettings/social_settings.vue";
import WebPrivacyPolicySettings from "../pages/WebsiteSettings/privacy_policy_settings.vue";
import WebCookiePolicySettings from "../pages/WebsiteSettings/cookie_policy_settings.vue";
import WebTermsSettings from "../pages/WebsiteSettings/terms_settings.vue";
import Profile from "../pages/profile/profile.vue";
import Details from "../pages/profile/subComponents/details.vue";
import EditProfile from "../pages/profile/subComponents/editProfile.vue";
import ChangePassword from "../pages/profile/subComponents/changePassword.vue";
import NotificationSettings from "../pages/profile/subComponents/notificationSettings.vue";
import AccountSettings from "../pages/profile/subComponents/accountSettings.vue";
import BlogList from "../pages/blog/cms/home.vue";
import CreateBlog from "../pages/blog/cms/create.vue";
import EditBlog from "../pages/blog/cms/edit.vue";
import Users from "../pages/users/users.vue";
import UserCreate from "../pages/users/user-create.vue";
import UserEdit from "../pages/users/user-edit.vue";
import Workshops from "../pages/workshops/workshops.vue";
import WorkshopCreate from "../pages/workshops/workshop-create.vue";
import WorkshopEdit from "../pages/workshops/workshop-edit.vue";
import WorkshopPreview from "../pages/workshops/workshop-preview.vue";
import EvaluationCertification from "../pages/certification/evaluation-certification.vue";
import EvaluationCertificationSettings from "../pages/certification/evaluation-certification-settings.vue";
import ParticipationCertification from "../pages/certification/participation-certification.vue";
import ParticipantCertificationSettings from "../pages/certification/participant-certification-settings.vue";

// Defining the root URL for the routes
const ROOT_URL = "/secure/administration";

// Setting up routes
const routes = [
    { path: ROOT_URL + '/auth/login', name: 'Login', component: Login },
    {
        path: ROOT_URL, name: 'Layout', component: Layout,
        children: [
            { path: ROOT_URL + '/', redirect: { name: 'Dashboard' } },
            { path: ROOT_URL + '/dashboard', name: 'Dashboard', component: Dashboard },
            { path: ROOT_URL + '/profile', name: 'Profile', component: Profile },
            { path: ROOT_URL + '/evaluation/risk-factors', name: 'RiskFactors', component: RiskFactors },
            { path: ROOT_URL + '/evaluation/sectors', name: 'Sectors', component: Sectors },
            { path: ROOT_URL + '/fair-decision/sectors', name: 'FdSectors', component: FdSectors },

            { path: ROOT_URL + '/evaluation/non-tech/questionnaires', name: 'ntQuestionnaires', component: ntQuestionnaires },
            { path: ROOT_URL + '/evaluation/chat-gpt/questionnaires', name: 'cgptQuestionnaires', component: cgptQuestionnaires },
            { path: ROOT_URL + '/evaluation/tech/general/Questionnaires', name: 'etQuestionnaires', component: etQuestionnaires },
            { path: ROOT_URL + '/evaluation/tech/application/Questionnaires', name: 'etaQuestionnaires', component: etaQuestionnaires },
            { path: ROOT_URL + '/evaluation/fair-decision-general/questionnaires', name: 'fdQuestionnaires', component: fdQuestionnaires },
            { path: ROOT_URL + '/evaluation/fair-decision-domain/questionnaires', name: 'etaFdQuestionnaires', component: etaFdQuestionnaires },

            { path: ROOT_URL + '/evaluation/awareness', name: 'Awareness', component: Awareness },
            { path: ROOT_URL + '/evaluation/awareness/create', name: 'AwarenessCreate', component: AwarenessCreate },
            { path: ROOT_URL + '/evaluation/awareness/edit/:course_id', name: 'AwarenessEdit', component: AwarenessEdit },
            {
                path: ROOT_URL + '/evaluation/awareness/preview/:course_id', name: 'AwarenessPreview', component: AwarenessPreview,
                children: [
                    {path: ROOT_URL + '/evaluation/awareness/preview/:course_id/topic/:topic_id/create', name: 'LessonCreate', component: LessonCreate,},
                    {path: ROOT_URL + '/evaluation/awareness/preview/:course_id/topic/:topic_id/edit/:lesson_id', name: 'LessonEdit', component: LessonEdit,},
                    {path: ROOT_URL + '/evaluation/awareness/preview/:course_id/topic/:topic_id/preview/:lesson_id', name: 'LessonPreview', component: LessonPreview,}
                ]
            },

            { path: ROOT_URL + '/evaluation/awareness/learners-and-teachers', name: 'AwarenessLearnerTeacher', component: AwarenessLearnerTeacher },

            { path: ROOT_URL + '/website/settings/home', name: 'WebHomeSettings', component: WebHomeSettings },
            { path: ROOT_URL + '/website/settings/safety', name: 'WebSafetySettings', component: WebSafetySettings },
            { path: ROOT_URL + '/website/settings/evaluation', name: 'WebEvaluationSettings', component: WebEvaluationSettings },
            { path: ROOT_URL + '/website/settings/fair_decision', name: 'WebFairDecisionSettings', component: WebFairDecisionSettings },
            { path: ROOT_URL + '/website/settings/training', name: 'WebTrainingSettings', component: WebTrainingSettings },
            { path: ROOT_URL + '/website/settings/awareness', name: 'WebAwarenessSettings', component: WebAwarenessSettings },
            { path: ROOT_URL + '/website/settings/certification', name: 'WebCertificationSettings', component: WebCertificationSettings },
            { path: ROOT_URL + '/website/settings/team', name: 'WebTeamSettings', component: WebTeamSettings },
            { path: ROOT_URL + '/website/settings/meta', name: 'WebMetaSettings', component: WebMetaSettings },
            { path: ROOT_URL + '/website/settings/contact', name: 'WebContactSettings', component: WebContactSettings },
            { path: ROOT_URL + '/website/settings/social', name: 'WebSocialSettings', component: WebSocialSettings },
            { path: ROOT_URL + '/website/settings/privacy-policy', name: 'WebPrivacyPolicySettings', component: WebPrivacyPolicySettings },
            { path: ROOT_URL + '/website/settings/cookie-policy', name: 'WebCookiePolicySettings', component: WebCookiePolicySettings },
            { path: ROOT_URL + '/website/settings/terms-and-conditions', name: 'WebTermsSettings', component: WebTermsSettings },
            { path: ROOT_URL + '/news-events', name: 'BlogList', component: BlogList },
            { path: ROOT_URL + '/news-events/create', name: 'CreateBlog', component: CreateBlog },
            { path: ROOT_URL + '/news-events/:blog_id', name: 'EditBlog', component: EditBlog },
            { path: ROOT_URL + '/users', name: 'Users', component: Users },
            { path: ROOT_URL + '/user/create', name: 'UserCreate', component: UserCreate },
            { path: ROOT_URL + '/user/edit/:user_id', name: 'UserEdit', component: UserEdit },
            { path: ROOT_URL + '/workshops', name: 'Workshops', component: Workshops },
            { path: ROOT_URL + '/workshop/create', name: 'WorkshopCreate', component: WorkshopCreate },
            { path: ROOT_URL + '/workshop/edit/:workshop_id', name: 'WorkshopEdit', component: WorkshopEdit },
            { path: ROOT_URL + '/workshop/preview/:workshop_id', name: 'WorkshopPreview', component: WorkshopPreview },
            { path: ROOT_URL + '/certification/evaluation', name: 'EvaluationCertification', component: EvaluationCertification },
            { path: ROOT_URL + '/certification/evaluation/settings', name: 'EvaluationCertificationSettings', component: EvaluationCertificationSettings },
            { path: ROOT_URL + '/certification/participation', name: 'ParticipationCertification', component: ParticipationCertification },
            { path: ROOT_URL + '/certification/participation/settings', name: 'ParticipantCertificationSettings', component: ParticipantCertificationSettings },
            {
                path: ROOT_URL + '/profile', name: 'ProfileLayout', component: Profile,
                children: [
                    { path: ROOT_URL + '/profile', name: 'Profile', component: Details },
                    { path: ROOT_URL + '/profile/editProfile', name: 'EditProfile', component: EditProfile },
                    { path: ROOT_URL + '/profile/changePassword', name: 'ChangePassword', component: ChangePassword },
                    { path: ROOT_URL + '/profile/notificationSettings', name: 'NotificationSettings', component: NotificationSettings },
                    { path: ROOT_URL + '/profile/accountSettings', name: 'AccountSettings', component: AccountSettings },
                ]
            },
        ],
    },
];

// Creating router instance
const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
