// Define the API version
const ApiVersion = "/api/portal";

// Define API routes using the API version
const ApiRoutes = {
    profile_update: ApiVersion + "/profile/update",
    profile_update_password: ApiVersion + "/profile/update/password",
    user_evaluations: ApiVersion + "/user/evaluations",
    user_evaluation_details: ApiVersion + "/user/evaluation/details",
    user_evaluation_report: ApiVersion + "/user/evaluation/report",
    user_evaluation_certificate: ApiVersion + "/user/evaluation/certificate",
    user_evaluation_delete: ApiVersion + "/user/evaluation/delete",
    user_evaluation_question_single: ApiVersion + "/user/evaluation/question/single",
    user_evaluation_question_single_chatGPT: ApiVersion + "/user/evaluation/question/single/chatGPT",
    user_evaluation_question_single_update: ApiVersion + "/user/evaluation/question/single/update",
};

// Export the API routes for use in other modules
export default ApiRoutes;
