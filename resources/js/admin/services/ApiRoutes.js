// Define the API version for the routes
const ApiVersion = "/api/secure/admin";

// Define API routes using the API version
const ApiRoutes = {
    Login: ApiVersion + "/auth/login",
    Logout: ApiVersion + "/auth/logout",

    // General Profile routes
    Profile: ApiVersion + "/general/me",
    UpdateProfile: ApiVersion + "/general/profile/update",
    ChangePassword: ApiVersion + "/general/change/password",

    // Dashboard report routes
    EvaluationSectorCharts: ApiVersion + "/dashboard/report/evaluations",
    FairDecisionDomainsCharts: ApiVersion + "/dashboard/report/fair-decision",
    RegisteredUsersCharts: ApiVersion + "/dashboard/report/registered-users",

    // Evaluation and Risk Factor routes
    RiskFactorGetAll: ApiVersion + "/evaluation/risk-factor/get/all",
    RiskFactorManage: ApiVersion + "/evaluation/risk-factor/manage",
    EvaluationSectorGetAll: ApiVersion + "/evaluation/sector/get/all",
    EvaluationSectorManage: ApiVersion + "/evaluation/sector/manage",
    fdSectorSectorGetAll: ApiVersion + "/evaluation/fd/sector/get/all",
    fdSectorSectorManage: ApiVersion + "/evaluation/fd/sector/manage",
    QuestionGroupsGetAll: ApiVersion + "/evaluation/question/groups/get/all",
    QuestionGroupsManage: ApiVersion + "/evaluation/question/groups/manage",

    // Awareness Evaluation routes
    AwarenessEvaluationSections: ApiVersion + "/evaluation/awareness/section/list",
    AwarenessEvaluationSectionCreate: ApiVersion + "/evaluation/awareness/section/create",
    AwarenessEvaluationSectionUpdate: ApiVersion + "/evaluation/awareness/section/update",
    AwarenessEvaluationSectionDelete: ApiVersion + "/evaluation/awareness/section/delete",
    AwarenessEvaluationSectionQuestionManage: ApiVersion + "/evaluation/awareness/section/question/manage",
    AwarenessEvaluationSectionQuestionDelete: ApiVersion + "/evaluation/awareness/section/question/delete",

    // Question routes
    ListQuestions: ApiVersion + "/question/list",
    ManageQuestion: ApiVersion + "/question/manage",
    DeleteQuestion: ApiVersion + "/question/delete",

    // Website settings route
    WebsiteSettings: ApiVersion + "/website_settings",

    // Blog routes
    CreateBlog: ApiVersion + "/blog",
    UpdateBlog: ApiVersion + "/blog",
    BlogList: ApiVersion + "/blog",
    ViewBlog: ApiVersion + "/blog",

    // User routes
    Users: ApiVersion + "/user/list",
    CreateUser: ApiVersion + "/user/create",
    GetUser: ApiVersion + "/user/single",
    UpdateUser: ApiVersion + "/user/update",
    DeleteUser: ApiVersion + "/user/delete",

    // Workshop routes
    Workshops: ApiVersion + "/workshop/list",
    CreateWorkshop: ApiVersion + "/workshop/create",
    GetWorkshop: ApiVersion + "/workshop/single",
    GetWorkshopCertificates: ApiVersion + "/workshop/certificates",
    UpdateWorkshop: ApiVersion + "/workshop/update",
    DeleteWorkshop: ApiVersion + "/workshop/delete",

    // Certification routes
    EvaluationCertificates: ApiVersion + "/evaluation/certificate/list",
    EvaluationCertificateSettings: ApiVersion + "/evaluation/certificate/settings",
    EvaluationCertificateSettingsUpdate: ApiVersion + "/evaluation/certificate/settings/update",
    ParticipantCertificates: ApiVersion + "/participant/certificate/list",

    // Media upload route
    MEDIA: ApiVersion + "/media/upload",
};

export default ApiRoutes;
