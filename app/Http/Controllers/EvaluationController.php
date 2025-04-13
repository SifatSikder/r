<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\CertificateSettings;
use App\Models\Evaluation;
use App\Models\EvaluationCertificates;
use App\Models\EvaluationSectors;
use App\Models\FairDecisionSectors;
use App\Models\QuestionGroups;
use App\Models\QuestionMitigations;
use App\Models\Questionnaires;
use App\Models\User;
use App\Repositories\Front\EvaluationRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends BaseController
{
    /**
     * Retrieve evaluation sectors and their sub-sectors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_sectors(Request $request)
    {
        try {
            // Retrieve top-level evaluation sectors with sub-sectors using eager loading
            $sectors = EvaluationSectors::with('sub_sectors')->where('parent_id', 0)->get()->toArray();

            // Return a JSON response with the retrieved data and a success status
            return response()->json(['status' => 200, 'data' => $sectors], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Retrieve Fair Decision evaluation sectors and their sub-sectors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_fd_sectors(Request $request)
    {
        try {
            // Retrieve top-level Fair Decision evaluation sectors with sub-sectors using eager loading
            $sectors = FairDecisionSectors::with('sub_sectors')->where('parent_id', 0)->get()->toArray();

            // Return a JSON response with the retrieved data and a success status
            return response()->json(['status' => 200, 'data' => $sectors], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Retrieve Single Fair Decision evaluation sector, and it's sub-sectors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_fd_sector_single(Request $request)
    {
        try {
            // Retrieve top-level Fair Decision evaluation sectors with sub-sectors using eager loading
            $sector = FairDecisionSectors::with('sub_sectors')->where('uid', (int)$request->uid)->where('parent_id', 0)->first();

            // Return a JSON response with the retrieved data and a success status
            return response()->json(['status' => 200, 'data' => $sector], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Retrieve evaluation question groups based on the specified domain.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_question_groups(Request $request)
    {
        try {
            // Check if a specific domain is specified in the request
            if ($request->domain == null) {
                // Retrieve question groups where the domain is null
                $groups = QuestionGroups::whereNull('domain')->get();
            } else {
                // Retrieve question groups where the domain is not null
                $groups = QuestionGroups::whereNotNull('domain')->get();
            }

            // Return a JSON response with the retrieved data and a success status
            return response()->json(['status' => 200, 'data' => $groups], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Retrieve technical evaluation questions based on the specified criteria.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_technical_questions(Request $request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Fetch questions based on the specified criteria
            $questions = Questionnaires::whereIn('category', ['et', 'eta', 'eta-fd'])
                ->where(function ($q) use ($input) {
                    // Check if 'category' is set and not empty
                    if (isset($input['category']) && $input['category'] != '') {
                        $q->where('category', $input['category']);
                    }
                    // Check if 'group' is set and not empty
                    if (isset($input['group']) && $input['group'] != '') {
                        $q->where('group', $input['group']);
                    }
                    // Check if 'sector' is set and greater than 0
                    if (isset($input['sector']) && $input['sector'] > 0) {
                        $q->where('sector', (int)$input['sector']);
                    }
                    // Check if 'sub_sector' is set and greater than 0
                    if (isset($input['sub_sector']) && $input['sub_sector'] > 0) {
                        $q->where('sub_sector', (int)$input['sub_sector']);
                    }
                })
                ->get()->toArray();

            // Process each question to convert line breaks in question and option titles
            foreach ($questions as &$question) {
                $question['question'] = nl2br($question['question']);
                $question['option_1']['title'] = nl2br($question['option_1']['title']);
                $question['option_2']['title'] = nl2br($question['option_2']['title']);
                $question['option_3']['title'] = nl2br($question['option_3']['title']);
                $question['option_4']['title'] = nl2br($question['option_4']['title']);
            }

            // Return a JSON response with the retrieved data and a success status
            return response()->json(['status' => 200, 'data' => $questions], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Retrieve non-technical evaluation questions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_non_technical_questions(Request $request)
    {
        try {
            // Fetch non-technical questions
            $questions = Questionnaires::where('category', 'nt')->get()->toArray();

            // Process each question to convert line breaks in question and option titles to HTML format
            foreach ($questions as &$question) {
                $question['question'] = nl2br($question['question']);
                $question['option_1']['title'] = nl2br($question['option_1']['title']);
                $question['option_2']['title'] = nl2br($question['option_2']['title']);
                $question['option_3']['title'] = nl2br($question['option_3']['title']);
                $question['option_4']['title'] = nl2br($question['option_4']['title']);
            }

            // Return a JSON response with the retrieved data and a success status
            return response()->json(['status' => 200, 'data' => $questions], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Retrieve fair decision evaluation questions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_fd_questions(Request $request)
    {
        try {
            // Fetch fair decision questions
            $questions = Questionnaires::where('category', 'fd')->get()->toArray();

            // Process each question to convert line breaks in question and option titles to HTML format
            foreach ($questions as &$question) {
                $question['question'] = nl2br($question['question']);
                $question['option_1']['title'] = nl2br($question['option_1']['title']);
                $question['option_2']['title'] = nl2br($question['option_2']['title']);
                $question['option_3']['title'] = nl2br($question['option_3']['title']);
                $question['option_4']['title'] = nl2br($question['option_4']['title']);
            }

            // Return a JSON response with the retrieved data and a success status
            return response()->json(['status' => 200, 'data' => $questions], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Perform risk evaluation and update or create an evaluation record.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function risk_evaluation(Request $request)
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'risk_evaluation' => 'required|array'
            ]);

            // Check for validation errors
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()], 200);
            }

            // Check if the evaluation ID is provided in the input
            if (isset($input['risk_evaluation']['_id'])) {
                // Update an existing evaluation
                $evaluation = Evaluation::where('_id', $input['risk_evaluation']['_id'])
                    ->where('user_id', Auth::id())
                    ->first();

                // Update answers and reset the report
                $evaluation->answers = $input['risk_evaluation']['answers'];
                $evaluation->report = null;
                $evaluation->save();
            } else {
                // Create a new evaluation
                $input['risk_evaluation']['user_id'] = Auth::id();
                $input['risk_evaluation']['report'] = null;
                $evaluation = Evaluation::create($input['risk_evaluation']);
            }

            // Return a JSON response with the updated or created evaluation data and a success status
            return response()->json(['status' => 200, 'data' => $evaluation], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Retrieve details of a user's evaluation based on the provided evaluation ID.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_evaluation_details(Request $request)
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'evaluation_id' => 'required'
            ]);

            // Check for validation errors
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()], 200);
            }

            // Retrieve the evaluation details based on the provided evaluation ID
            $evaluation = Evaluation::where('_id', $input['evaluation_id'])->first();

            // Check if the evaluation exists
            if (!$evaluation) {
                return response()->json(['status' => 500, 'error' => ['Invalid Request!']], 200);
            }

            // Return a JSON response with the evaluation details and a success status
            return response()->json(['status' => 200, 'evaluation' => $evaluation], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Retrieve the risk evaluation report for a user's evaluation based on the provided evaluation ID.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_evaluation_report(Request $request)
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'evaluation_id' => 'required'
            ]);

            // Check for validation errors
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()], 200);
            }

            // Retrieve the risk evaluation report based on the provided evaluation ID
            $riskEvaluation = EvaluationRepository::riskEvaluation($input['evaluation_id']);

            // Check if the risk evaluation exists
            if (!$riskEvaluation) {
                return response()->json(['status' => 500, 'error' => ['Invalid Request!']], 200);
            }

            // Return a JSON response with the risk evaluation report and a success status
            return response()->json(['status' => 200, 'risk_evaluation' => $riskEvaluation], 200);

        } catch (\Exception $e) {
            // Return a JSON response with an error status and the exception message if an error occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage(), 'line' => $e->getLine()], 200);
        }
    }

    /**
     * Generate and display the certificate for a user's evaluation based on the provided evaluation ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $evaluation_id
     * @return mixed
     */
    public function user_evaluation_certificate(Request $request, $evaluation_id)
    {
        try {
            $certificate = 0;

            // Retrieve risk evaluation information based on the provided evaluation ID
            $riskEvaluation = Evaluation::where('_id', $evaluation_id)->first();

            // Check if risk evaluation exists and convert it to an array
            if ($riskEvaluation != null) {
                $riskEvaluation = $riskEvaluation->toArray();
            }

            // Check if the risk evaluation has a report and a riskPercentage section
            if (isset($riskEvaluation['report']) && isset($riskEvaluation['report']['riskPercentage'])) {
                // Check if the riskPercentage section has a 'No' key with a value of 100
                if (isset($riskEvaluation['report']['riskPercentage']['No']) && $riskEvaluation['report']['riskPercentage']['No'] == 100) {
                    $certificate = 1;
                }
            }

            // Generate and display the certificate if it meets the criteria
            if ($certificate == 1) {
                $user = User::where('_id', Auth::id())->first();

                // Check if the user has a premium subscription
                if ($user->subscription_type == 'premium') {
                    // Populate additional data for the certificate
                    $riskEvaluation['user'] = User::where('_id', $riskEvaluation['user_id'])->first();
                    $riskEvaluation['cert_settings'] = CertificateSettings::where('type', 'evaluation')->first();

                    // Check if certificate settings exist and convert them to an array
                    if ($riskEvaluation['cert_settings'] != null) {
                        $riskEvaluation['cert_settings'] = $riskEvaluation['cert_settings']->toArray();
                        $riskEvaluation['cert_settings']['description_letter'] = str_replace('[--Evaluation--]', '<strong>' . $riskEvaluation['project']['name'] . '</strong>', $riskEvaluation['cert_settings']['description_letter']);
                        $riskEvaluation['cert_settings']['description_letter'] = str_replace('[--Date--]', '<strong>' . date('d M, Y') . '</strong>', $riskEvaluation['cert_settings']['description_letter']);
                    }

                    // Create the 'certificate' directory if it doesn't exist
                    if (!file_exists(public_path('storage/media/certificate'))) {
                        mkdir(public_path('storage/media/certificate'), 0777);
                    }

                    // Generate the PDF certificate
                    $pdf = Pdf::loadView('pdf.certificate_evaluation', $riskEvaluation);
                    $pdf->setPaper('a3', 'landscape');

                    // Define the PDF name and path
                    $pdfName = 'Certificate_of_Evaluation_' . $evaluation_id . '.pdf';
                    $pdfPath = public_path('storage/media/certificate/' . $pdfName);
                    $pdf->save($pdfPath);

                    // Check if an EvaluationCertificate record already exists for the evaluation ID
                    $EvaluationCertificate = EvaluationCertificates::where('evaluation_id', $evaluation_id)->first();

                    // Create a new EvaluationCertificate record if none exists
                    if ($EvaluationCertificate == null) {
                        EvaluationCertificates::create([
                            'evaluation_id' => $evaluation_id,
                            'full_name' => $user->name,
                            'email' => $user->email,
                            'file_path' => $pdfName
                        ]);
                    }

                    // Return the generated PDF for streaming
                    return $pdf->stream($pdfName);
                } else {
                    // Return an error message for free users
                    return "This request is invalid for Free Users!";
                }
            } else {
                // Return an error message for invalid requests with no certificate found
                return "Invalid Request! No Certificate Found.";
            }
        } catch (\Exception $e) {
            // Return an error message for any exceptions that occur
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Delete a user's evaluation based on the provided evaluation ID.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_evaluation_delete(Request $request)
    {
        try {
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'evaluation_id' => 'required'
            ]);

            // Check for validation failures and return an error response if needed
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()], 200);
            }

            // Delete the evaluation based on the provided evaluation ID
            Evaluation::where('_id', $request->evaluation_id)->delete();

            // Return a success response after successful deletion
            return response()->json(['status' => 200, 'msg' => 'Evaluation has been deleted successfully.'], 200);
        } catch (\Exception $e) {
            // Return an error response for any exceptions that occur
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Get details of a single question from the user's evaluation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_evaluation_question_single(Request $request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'group' => 'required',
                'q_index' => 'required',
                'evaluation_id' => 'required',
            ]);

            // Check for validation failures and return an error response if needed
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()], 200);
            }

            // Retrieve the user's evaluation based on the provided evaluation ID
            $evaluation = Evaluation::where('_id', $request->evaluation_id)->first();

            // Extract group-specific answers based on the provided group
            if ($input['group'] == 'eta') {
                if ($evaluation->evaluation_sub_sector != null) {
                    $groupAnswers = $evaluation->answers['domain_' . $evaluation->evaluation_sector . '_' . $evaluation->evaluation_sub_sector] ?? null;
                } else {
                    $groupAnswers = $evaluation->answers['domain_' . $evaluation->evaluation_sector] ?? null;
                }
            } else if ($input['group'] == 'eta-fd') {

                $groupAnswers = $evaluation->answers[$input['fd_index']] ?? null;

            } elseif ($input['group'] == 'nt') {
                $groupAnswers = $evaluation->answers['nt'] ?? null;
            } elseif ($input['group'] == 'fd') {
                $groupAnswers = $evaluation->answers['fd'] ?? null;
            } else {
                $groupAnswers = $evaluation->answers['domain_' . $input['group']] ?? null;
            }

            // Check if group-specific answers are available
            if ($groupAnswers == null) {
                return response()->json(['status' => 500, 'error' => ['Invalid Request!']], 200);
            }

            // Extract question index and related information
            $qIndex = str_replace('q', '', $input['q_index']) - 1;
            $qIds = [];
            foreach ($groupAnswers as $qUid => $groupAnswer) {
                $qIds[] = substr($qUid, 0, strpos($qUid, "_"));
            }
            $qIds = array_values(array_unique($qIds));
            $qId = $qIds[$qIndex];

            // Retrieve the details of the question based on the extracted question ID
            $question = Questionnaires::where('_id', $qId)->first();

            // Convert the question details to an array for response
            if ($question != null) {
                $question = $question->toArray();
            }

            // Extract and attach answers to the question details
            foreach ($groupAnswers as $qUid => $groupAnswer) {
                if ($qUid == $qId . '_q1') {
                    $question['option_1']['answer'] = $groupAnswer;
                }
                if ($qUid == $qId . '_q2') {
                    $question['option_2']['answer'] = $groupAnswer;
                }
                if ($qUid == $qId . '_q3') {
                    $question['option_3']['answer'] = $groupAnswer;
                }
                if ($qUid == $qId . '_q4') {
                    $question['option_4']['answer'] = $groupAnswer;
                }
            }

            // Return the question details along with answers in the response
            return response()->json(['status' => 200, 'data' => $question], 200);
        } catch (\Exception $e) {
            // Return an error response for any exceptions that occur
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Get details of a single question from the user's evaluation for ChatGPT interaction.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_evaluation_question_single_chatGPT(Request $request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                '_id' => 'required',
                'evaluation_id' => 'required',
                'risk' => 'required',
            ]);

            // Check for validation failures and return an error response if needed
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()], 200);
            }

            // Retrieve the details of the question based on the provided question ID
            $question = Questionnaires::where('_id', $request->_id)->first();

            // Retrieve the user's evaluation based on the provided evaluation ID
            $evaluation = Evaluation::where('_id', $request->evaluation_id)->first();

            // Handle specific sectors and sub-sectors for 'eta' and 'eta-fd' categories
            if ($question->category == 'eta') {
                $evaluation['sector'] = EvaluationSectors::where('parent_id', 0)->where('uid', (int)$evaluation->evaluation_sector)->first();
                $evaluation['sub_sector'] = EvaluationSectors::where('parent_id', (int)$evaluation->evaluation_sector)->where('uid', $evaluation->evaluation_sub_sector)->first();
            } else if ($question->category == 'eta-fd') {
                $evaluation['sector'] = FairDecisionSectors::where('parent_id', 0)->where('uid', (int)$evaluation->evaluation_sector)->first();
                $evaluation['sub_sector'] = FairDecisionSectors::where('parent_id', (int)$evaluation->evaluation_sector)->where('uid', $evaluation->evaluation_sub_sector)->first();
            }

            // Extract group-specific answers based on the question's category
            if ($question->category == 'eta') {
                if ($evaluation->evaluation_sub_sector != null) {
                    $groupAnswers = $evaluation->answers['domain_' . $evaluation->evaluation_sector . '_' . $evaluation->evaluation_sub_sector] ?? null;
                } else {
                    $groupAnswers = $evaluation->answers['domain_' . $evaluation->evaluation_sector] ?? null;
                }
            } else if ($question->category == 'eta-fd') {
                $groupAnswers = $evaluation->answers[$input['fd_index']] ?? null;
            } elseif ($question->category == 'nt') {
                $groupAnswers = $evaluation->answers['nt'] ?? null;
            } elseif ($question->category == 'fd') {
                $groupAnswers = $evaluation->answers['fd'] ?? null;
            } else {
                $group = QuestionGroups::where('title', $question->group)->first();
                $groupAnswers = $evaluation->answers['domain_' . $group->uid] ?? null;
            }

            // Check if group-specific answers are available
            if ($groupAnswers == null) {
                return response()->json(['status' => 500, 'error' => ['Invalid Request!']], 200);
            }

            // Convert the question details to an array for response
            if ($question != null) {
                $question = $question->toArray();
            }

            // Extract and attach answers to the question details
            $qId = $question['_id'];
            foreach ($groupAnswers as $qUid => $groupAnswer) {
                if ($qUid == $qId . '_q1') {
                    $question['option_1']['answer'] = $groupAnswer;
                }
                if ($qUid == $qId . '_q2') {
                    $question['option_2']['answer'] = $groupAnswer;
                }
                if ($qUid == $qId . '_q3') {
                    $question['option_3']['answer'] = $groupAnswer;
                }
                if ($qUid == $qId . '_q4') {
                    $question['option_4']['answer'] = $groupAnswer;
                }
            }

            // Retrieve the user details for premium subscription check
            $user = User::where('_id', Auth::id())->first();

            // Proceed if the user has a premium subscription
            if ($user->subscription_type == 'premium') {
                $question['mitigation'] = QuestionMitigations::where('q_id', $qId)->where('evaluation_id', $request->evaluation_id)->where('user_id', Auth::id())->first();
                if ($question['mitigation'] == null && $input['risk'] != 'No') {
                    $questionGPT = 'I am using a Risk evaluation system for AI systems. ';
                    if ($question['category'] == 'eta' || $question['category'] == 'eta-fd') {
                        $questionGPT .= 'I did make an evaluation where my technology uses in ' . $evaluation['sector']->title . '. domain falls under the ';
                    } elseif ($question['category'] == 'nt') {
                        $questionGPT .= 'I did make an evaluation as non technology uses falls under the ';
                    } else {
                        $questionGPT .= 'I did make an evaluation as technology uses falls under the ';
                    }
                    if ($question['category'] == 'eta' || $question['category'] == 'nt' || $question['category'] == 'fd') {
                        $questionGPT .= $evaluation['report']['risk_report']['questionRiskLevel'][$input['q_index']];
                    } else if ($question['category'] == 'eta-fd') {
                        $questionGPT .= $evaluation['report']['sections'][$evaluation['sub_sector']->uid - 1]['risk_report']['questionRiskLevel'][$input['q_index']];
                    } else {
                        $questionGPT .= $evaluation['report']['sections'][$group->uid - 1]['risk_report']['questionRiskLevel'][$input['q_index']];
                    }
                    $questionGPT .= ' Risk level. ';
                    if ($question['option_1']['title'] != null) {
                        $questionGPT .= 'Firstly, for ';
                        $questionGPT .= $question['option_1']['title'];
                        $questionGPT .= 'I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($question['option_1']['answer']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $question['option_1']['risk_level'];
                        $questionGPT .= ' risk in that system. ';
                    }
                    if ($question['option_2']['title'] != null) {
                        $questionGPT .= 'Secondly, for ';
                        $questionGPT .= $question['option_2']['title'];
                        $questionGPT .= 'I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($question['option_2']['answer']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $question['option_2']['risk_level'];
                        $questionGPT .= ' risk in that system. ';
                    }
                    if ($question['option_3']['title'] != null) {
                        $questionGPT .= 'Thirdly, for ';
                        $questionGPT .= $question['option_3']['title'];
                        $questionGPT .= 'I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($question['option_3']['answer']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $question['option_3']['risk_level'];
                        $questionGPT .= ' risk in that system. ';
                    }
                    if ($question['category'] == 'eta' || $question['category'] == 'nt' || $question['category'] == 'fd') {
                        $questionGPT .= ' Tell me why the risk level for this section is ' . $evaluation['report']['risk_report']['questionRiskLevel'][$input['q_index']] . ' and what is the mitigation strategies? ';
                    } else if ($question['category'] == 'eta-fd') {
                        $questionGPT .= ' Tell me why the risk level for this section is ' . $evaluation['report']['sections'][$evaluation['sub_sector']->uid - 1]['risk_report']['questionRiskLevel'][$input['q_index']] . ' and what is the mitigation strategies? ';
                    } else {
                        $questionGPT .= ' Tell me why the risk level for this section is ' . $evaluation['report']['sections'][$group->uid - 1]['risk_report']['questionRiskLevel'][$input['q_index']] . ' and what is the mitigation strategies? ';
                    }
                    $chatGPT = Helpers::askChatGPT($questionGPT);
                    $question['mitigation'] = QuestionMitigations::create([
                        'q_id' => $qId,
                        'evaluation_id' => $request->evaluation_id,
                        'user_id' => Auth::id(),
                        'mitigation' => $chatGPT
                    ]);
                }
            }

            // Return the question details along with answers and mitigation in the response
            return response()->json(['status' => 200, 'data' => $question], 200);
        } catch (\Exception $e) {
            // Return an error response for any exceptions that occur
            return response()->json(['status' => 500, 'error' => $e->getMessage(), 'line' => $e->getLine()], 200);
        }
    }

    /**
     * Update user's answers for a single domain in their evaluation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_evaluation_question_single_update(Request $request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'answers' => 'required',
                'domain' => 'required',
                'evaluation_id' => 'required',
            ]);

            // Check for validation failures and return an error response if needed
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()], 200);
            }

            // Retrieve the user's evaluation based on the provided evaluation ID and user ID
            $evaluation = Evaluation::where('_id', $request->evaluation_id)->where('user_id', Auth::id())->first();

            // Check if the evaluation is valid
            if ($evaluation == null) {
                return response()->json(['status' => 500, 'error' => ['Invalid Request!']], 200);
            }

            // Convert the evaluation details to an array
            $evaluation = $evaluation->toArray();

            // Update answers based on the domain type
            if ($input['domain'] == 'domain_eta') {
                if (isset($evaluation['answers'])) {
                    $domainEta = 'domain_' . $evaluation['evaluation_sector'];
                    if ($evaluation['evaluation_sub_sector'] != null) {
                        $domainEta .= '_' . $evaluation['evaluation_sub_sector'];
                    }
                    if (isset($evaluation['answers'][$domainEta])) {
                        foreach ($input['answers'] as $q => $answer) {
                            if (isset($evaluation['answers'][$domainEta][$q])) {
                                $evaluation['answers'][$domainEta][$q] = $answer;
                            }
                        }
                    }
                }
            } else if ($input['domain'] == 'eta-fd') {
                if (isset($evaluation['answers'])) {
                    $domainEta = $input['fd_index'];
                    if (isset($evaluation['answers'][$domainEta])) {
                        foreach ($input['answers'] as $q => $answer) {
                            if (isset($evaluation['answers'][$domainEta][$q])) {
                                $evaluation['answers'][$domainEta][$q] = $answer;
                            }
                        }
                    }
                }
            } else {
                if (isset($evaluation['answers'])) {
                    if (isset($evaluation['answers'][$input['domain']])) {
                        foreach ($input['answers'] as $q => $answer) {
                            if (isset($evaluation['answers'][$input['domain']][$q])) {
                                $evaluation['answers'][$input['domain']][$q] = $answer;
                            }
                        }
                    }
                }
            }

            // Update the evaluation with the modified answers and report
            Evaluation::where('_id', $request->evaluation_id)->update([
                'answers' => $evaluation['answers'],
                'report' => $evaluation['report']
            ]);

            // Return a success response
            return response()->json(['status' => 200, 'msg' => 'Answer has been updated successfully'], 200);
        } catch (\Exception $e) {
            // Return an error response for any exceptions that occur
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

}
