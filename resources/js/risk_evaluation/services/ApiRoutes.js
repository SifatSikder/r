const ApiVersion = "/api/portal";
const ApiRoutes = {
    // Auth
    Login: "/login-api",
    Register: "/register-api",
    // Evaluation
    fdSectors: ApiVersion + "/evaluation/fd/sectors",
    fdSectorDetails: ApiVersion + "/evaluation/fd/sector/details",
    EvaluationSectors: ApiVersion + "/evaluation/sectors",
    EvaluationGroups: ApiVersion + "/evaluation/question/groups",
    EvaluationTechnicalQuestions: ApiVersion + "/evaluation/technical/questions",
    EvaluationNonTechnicalQuestions: ApiVersion + "/evaluation/non-technical/questions",
    EvaluationFdQuestions: ApiVersion + "/evaluation/fd/questions",
    RiskEvaluationSubmit: ApiVersion + "/evaluation/submit",
    RiskEvaluationDetails: ApiVersion + "/user/evaluation/details",
    user_evaluation_report: ApiVersion + "/user/evaluation/report",
};

export default ApiRoutes;
