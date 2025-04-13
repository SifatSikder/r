<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\BotEvaluation;
use App\Models\Evaluation;
use App\Models\Questionnaires;
use App\Models\RiskFactors;
use App\Models\RiskMatrix;
use App\Repositories\Front\EvaluationRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BotEvaluationController extends BaseController
{
    /**
     * Retrieve non-technical questions for evaluation.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_non_tech_questions(Request $request)
    {
        try {
            // Retrieve non-technical questions from the questionnaire
            $questions = Questionnaires::where('category', 'cgpt')->get()->toArray();

            // Iterate through each question and format the text
            foreach ($questions as &$question) {
                $question['question'] = nl2br($question['question']);
                $question['option_1']['title'] = nl2br($question['option_1']['title']);
                $question['option_2']['title'] = nl2br($question['option_2']['title']);
                $question['option_3']['title'] = nl2br($question['option_3']['title']);
                $question['option_4']['title'] = nl2br($question['option_4']['title']);
            }

            // Return formatted questions as a JSON response
            return response()->json(['status' => 200, 'data' => $questions], 200);

        } catch (\Exception $e) {
            // Return JSON response with error details if an exception occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Submit Demo evaluation data.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submit(Request $request)
    {
        try {
            $input = $request->input();

            // Validate input data
            $validator = Validator::make($input, [
                'bot_evaluation' => 'required|array'
            ]);

            // Return JSON response with validation errors if they exist
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()], 200);
            }

            // Set user_id to null and generate a unique guest_id
            $input['bot_evaluation']['user_id'] = null;
            $input['bot_evaluation']['guest_id'] = uniqid();

            // Create a new BotEvaluation record
            BotEvaluation::create($input['bot_evaluation']);

            // Return JSON response with success status and generated guest_id
            return response()->json(['status' => 200, 'guest_id' => $input['bot_evaluation']['guest_id']], 200);

        } catch (\Exception $e) {
            // Return JSON response with error details if an exception occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Display the risk evaluation report for a guest user.
     *
     * @param Request $request
     * @param string $guest_id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function guest_report(Request $request, $guest_id)
    {
        // Retrieve the latest evaluation record for the given guest_id
        $evaluation = BotEvaluation::where('guest_id', $guest_id)->orderBy('created_at', 'desc')->first();

        // If the evaluation is not found or is null, abort with a 404 error
        if ($evaluation == null) {
            abort('404');
        }

        // Convert the evaluation to an array for further processing
        $evaluation = $evaluation->toArray();

        if($evaluation['category'] == 'ChatGPT_OLD'){
            $evaluation['chatbots'] = ['ChatGPT'];
            $totalChatBots = count($evaluation['chatbots']);
            if ($evaluation == null || $totalChatBots < 1) {
                abort('404');
            }

            $software_risk_factors = [];
            $hardware_risk_factors = [];
            $ethical_risk_factors = [];
            $legal_risk_factors = [];
            $risk_factors = RiskFactors::get()->toArray();
            foreach ($risk_factors as $risk_factor) {
                if ($risk_factor['software'] == 1) {
                    $software_risk_factors[] = $risk_factor;
                }
                if ($risk_factor['hardware'] == 1) {
                    $hardware_risk_factors[] = $risk_factor;
                }
                if ($risk_factor['ethical'] == 1) {
                    $ethical_risk_factors[] = $risk_factor;
                }
                if ($risk_factor['legal'] == 1) {
                    $legal_risk_factors[] = $risk_factor;
                }
            }

            $finalResult = [
                'software' => [],
                'hardware' => [],
                'ethical' => [],
                'legal' => [],
            ];

            $risk_martix = [];
            foreach ($evaluation['chatbots'] as $bot) {
                if (!empty($bot)) {
                    $matrix = RiskMatrix::where('name', $bot)->first();
                    if ($matrix != null) {
                        $risk_martix[$bot] = $matrix['matrix'][$evaluation['evaluation_sector']];
                    }

                    // Software Risk
                    $software_risk = [];
                    foreach ($software_risk_factors as $softRisk) {
                        foreach ($risk_martix[$bot]['risk_factors'] as $matrix) {
                            if ($matrix['uid'] == $softRisk['uid']) {
                                $software_risk[] = $matrix['risk'];
                            }
                        }
                    }
                    $software_risk = array_count_values($software_risk);
                    arsort($software_risk);
                    $software_risk = array_key_first($software_risk);
                    $risk_martix[$bot]['software_risk'] = $software_risk;
                    $finalResult['software'][] = $software_risk;

                    // Hardware Risk
                    $hardware_risk = [];
                    foreach ($hardware_risk_factors as $softRisk) {
                        foreach ($risk_martix[$bot]['risk_factors'] as $matrix) {
                            if ($matrix['uid'] == $softRisk['uid']) {
                                $hardware_risk[] = $matrix['risk'];
                            }
                        }
                    }
                    $hardware_risk = array_count_values($hardware_risk);
                    arsort($hardware_risk);
                    $hardware_risk = array_key_first($hardware_risk);
                    $risk_martix[$bot]['hardware_risk'] = $hardware_risk;
                    $finalResult['hardware'][] = $hardware_risk;

                    // Ethical Risk
                    $ethical_risk = [];
                    foreach ($ethical_risk_factors as $softRisk) {
                        foreach ($risk_martix[$bot]['risk_factors'] as $matrix) {
                            if ($matrix['uid'] == $softRisk['uid']) {
                                $ethical_risk[] = $matrix['risk'];
                            }
                        }
                    }
                    $ethical_risk = array_count_values($ethical_risk);
                    arsort($ethical_risk);
                    $ethical_risk = array_key_first($ethical_risk);
                    $risk_martix[$bot]['ethical_risk'] = $ethical_risk;
                    $finalResult['ethical'][] = $ethical_risk;

                    // Legal Risk
                    $legal_risk = [];
                    foreach ($legal_risk_factors as $softRisk) {
                        foreach ($risk_martix[$bot]['risk_factors'] as $matrix) {
                            if ($matrix['uid'] == $softRisk['uid']) {
                                $legal_risk[] = $matrix['risk'];
                            }
                        }
                    }
                    $legal_risk = array_count_values($legal_risk);
                    arsort($legal_risk);
                    $legal_risk = array_key_first($legal_risk);
                    $risk_martix[$bot]['legal_risk'] = $legal_risk;
                    $finalResult['legal'][] = $legal_risk;
                }
            }

            $finalResult['software'] = array_count_values($finalResult['software']);
            arsort($finalResult['software']);
            $software_risks = self::generateRiskPecentage($finalResult['software'], $totalChatBots);
            $finalResult['software'] = array_key_first($finalResult['software']);

            $finalResult['hardware'] = array_count_values($finalResult['hardware']);
            arsort($finalResult['hardware']);
            $hardware_risks = self::generateRiskPecentage($finalResult['hardware'], $totalChatBots);
            $finalResult['hardware'] = array_key_first($finalResult['hardware']);

            $finalResult['ethical'] = array_count_values($finalResult['ethical']);
            arsort($finalResult['ethical']);
            $ethical_risks = self::generateRiskPecentage($finalResult['ethical'], $totalChatBots);
            $finalResult['ethical'] = array_key_first($finalResult['ethical']);

            $finalResult['legal'] = array_count_values($finalResult['legal']);
            arsort($finalResult['legal']);
            $legal_risks = self::generateRiskPecentage($finalResult['legal'], $totalChatBots);
            $finalResult['legal'] = array_key_first($finalResult['legal']);

            $project_risk_evaluation = array_values($finalResult);
            $project_risk_evaluation = array_count_values($project_risk_evaluation);
            arsort($project_risk_evaluation);
            $project_risk_evaluation = array_key_first($project_risk_evaluation);

            $riskEvaluation = [
                'risk_factors' => $risk_factors,
                'evaluation' => $evaluation,
                'risk_martix' => $risk_martix,
                'final_result' => $finalResult,
                'project_risk_evaluation' => $project_risk_evaluation,
                'risk_percentages' => [
                    'software_risks' => $software_risks,
                    'hardware_risks' => $hardware_risks,
                    'ethical_risks' => $ethical_risks,
                    'legal_risks' => $legal_risks
                ]
            ];
            return view('Front.pages.dashboard.dashboard')->with($riskEvaluation);
        }
        else if($evaluation['category'] == 'fd'){
            $totalQuestions = Questionnaires::where('category', 'fd')->count();
            $weight = 1 / $totalQuestions;

            // Arrange and Grouped by Questions
            $qSet = [];
            foreach ($evaluation['answers']['fd'] as $sq => $sr){
                $qId = substr($sq, 0, strpos($sq, "_"));
                if(!isset($qSet[$qId])){
                    $qSet[$qId] = [];
                }
                $qSet[$qId][] = $sr;
            }
            // Calculate Risk for each Questions
            $sl = 0;
            $SectionQuestions = [];
            $SectionQuestionsRiskLevel = [];
            foreach ($qSet as $eachQSet){
                $sl++;
                $riskFactors = 0;
                $riskMembership = 0;
                foreach ($eachQSet as $qSetV){
                    $riskFactors = $riskFactors + ((float)$qSetV * $weight);
                    $riskMembership = $riskMembership + $weight;
                }
                $SectionQuestions['q'.$sl] = Helpers::num2format($riskFactors/$riskMembership);
                $SectionQuestionsRiskLevel['q'.$sl] = Evaluation::riskToLevel($SectionQuestions['q'.$sl]);
            }

            // Calculate Risk for each Section
            $riskFactors = 0;
            $riskMembership = 0;
            foreach ($SectionQuestions as $eachQRisk){
                $riskFactors = $riskFactors + ((float)$eachQRisk * $weight);
                $riskMembership = $riskMembership + $weight;
            }
            $SectionRisk = Helpers::num2format($riskFactors/$riskMembership);
            $risk_report = [
                'Risk' => $SectionRisk,
                'RiskLevel' => Evaluation::riskToLevel($SectionRisk),
                'questionRisk' => $SectionQuestions,
                'questionRiskLevel' => $SectionQuestionsRiskLevel,
            ];

            // RiskCounter
            $RiskCounter = ['Low' => 0, 'Limited' => 0, 'High' => 0, 'No' => 0];
            foreach ($SectionQuestionsRiskLevel as $ql){
                if($ql == 'Low'){ $RiskCounter['Low']++; }
                else if($ql == 'Limited'){ $RiskCounter['Limited']++; }
                else if($ql == 'High'){ $RiskCounter['High']++; }
                else if($ql == 'No'){ $RiskCounter['No']++; }
            }
            // RiskPercentage
            $RiskTotal = $RiskCounter['Low'] + $RiskCounter['Limited'] + $RiskCounter['High'] + $RiskCounter['No'];
            $RiskPercentage = [
                'Low' => round(Helpers::num2format(($RiskCounter['Low'] / $RiskTotal) * 100)),
                'Limited' => round(Helpers::num2format(($RiskCounter['Limited'] / $RiskTotal) * 100)),
                'High' => round(Helpers::num2format(($RiskCounter['High'] / $RiskTotal) * 100)),
                'No' => round(Helpers::num2format(($RiskCounter['No'] / $RiskTotal) * 100))
            ];

            $riskEvaluation = [
                'evaluation' => $evaluation,
                'riskPercentage' => $RiskPercentage,
                'risk_report' => $risk_report,
            ];
            return view('Front.pages.dashboard.dashboard-fd')->with($riskEvaluation);
        }
        else if($evaluation['category'] == 'cgpt'){
            $totalQuestions = Questionnaires::where('category', 'cgpt')->count();
            $weight = 1 / $totalQuestions;

            // Arrange and Grouped by Questions
            $qSet = [];
            foreach ($evaluation['answers']['cgpt'] as $sq => $sr){
                $qId = substr($sq, 0, strpos($sq, "_"));
                if(!isset($qSet[$qId])){
                    $qSet[$qId] = [];
                }
                $qSet[$qId][] = $sr;
            }
            // Calculate Risk for each Questions
            $sl = 0;
            $SectionQuestions = [];
            $SectionQuestionsRiskLevel = [];
            foreach ($qSet as $eachQSet){
                $sl++;
                $riskFactors = 0;
                $riskMembership = 0;
                foreach ($eachQSet as $qSetV){
                    $riskFactors = $riskFactors + ((float)$qSetV * $weight);
                    $riskMembership = $riskMembership + $weight;
                }
                $SectionQuestions['q'.$sl] = Helpers::num2format($riskFactors/$riskMembership);
                $SectionQuestionsRiskLevel['q'.$sl] = Evaluation::riskToLevel($SectionQuestions['q'.$sl]);
            }

            // Calculate Risk for each Section
            $riskFactors = 0;
            $riskMembership = 0;
            foreach ($SectionQuestions as $eachQRisk){
                $riskFactors = $riskFactors + ((float)$eachQRisk * $weight);
                $riskMembership = $riskMembership + $weight;
            }
            $SectionRisk = Helpers::num2format($riskFactors/$riskMembership);
            $risk_report = [
                'Risk' => $SectionRisk,
                'RiskLevel' => Evaluation::riskToLevel($SectionRisk),
                'questionRisk' => $SectionQuestions,
                'questionRiskLevel' => $SectionQuestionsRiskLevel,
            ];

            // RiskCounter
            $RiskCounter = ['Low' => 0, 'Limited' => 0, 'High' => 0, 'No' => 0];
            foreach ($SectionQuestionsRiskLevel as $ql){
                if($ql == 'Low'){ $RiskCounter['Low']++; }
                else if($ql == 'Limited'){ $RiskCounter['Limited']++; }
                else if($ql == 'High'){ $RiskCounter['High']++; }
                else if($ql == 'No'){ $RiskCounter['No']++; }
            }
            // RiskPercentage
            $RiskTotal = $RiskCounter['Low'] + $RiskCounter['Limited'] + $RiskCounter['High'] + $RiskCounter['No'];
            $RiskPercentage = [
                'Low' => round(Helpers::num2format(($RiskCounter['Low'] / $RiskTotal) * 100)),
                'Limited' => round(Helpers::num2format(($RiskCounter['Limited'] / $RiskTotal) * 100)),
                'High' => round(Helpers::num2format(($RiskCounter['High'] / $RiskTotal) * 100)),
                'No' => round(Helpers::num2format(($RiskCounter['No'] / $RiskTotal) * 100))
            ];

            $riskEvaluation = [
                'evaluation' => $evaluation,
                'riskPercentage' => $RiskPercentage,
                'risk_report' => $risk_report,
            ];
            return view('Front.pages.dashboard.dashboard-fd')->with($riskEvaluation);
        }


    }

    /**
     * Generate risk percentage data based on the provided risk levels and total number of chatbots.
     *
     * @param array $risk - An array containing risk levels ('Low', 'Limited', 'High', 'Unacceptable').
     * @param int $totalChatBots - Total number of chatbots for calculating percentages.
     * @return array - An array containing labels and corresponding percentage data.
     */
    public static function generateRiskPecentage($risk, $totalChatBots)
    {
        // Initialize arrays for labels and data
        $label = [];
        $data = [];

        // Check and process 'Low' risk level
        if (!isset($risk['Low'])) {
            $data[] = 0;
            $label[] = 'Low';
        } else {
            $percentage = Helpers::num2format(($risk['Low'] / $totalChatBots) * 100);
            $data[] = $percentage;
            $label[] = 'Low';
        }

        // Check and process 'Limited' risk level
        if (!isset($risk['Limited'])) {
            $data[] = 0;
            $label[] = 'Limited';
        } else {
            $percentage = Helpers::num2format(($risk['Limited'] / $totalChatBots) * 100);
            $data[] = $percentage;
            $label[] = 'Limited';
        }

        // Check and process 'High' risk level
        if (!isset($risk['High'])) {
            $data[] = 0;
            $label[] = 'High';
        } else {
            $percentage = Helpers::num2format(($risk['High'] / $totalChatBots) * 100);
            $data[] = $percentage;
            $label[] = 'High';
        }

        // Check and process 'Unacceptable' risk level
        if (!isset($risk['Unacceptable'])) {
            $data[] = 0;
            $label[] = 'Unacceptable';
        } else {
            $percentage = Helpers::num2format(($risk['Unacceptable'] / $totalChatBots) * 100);
            $data[] = $percentage;
            $label[] = 'Unacceptable';
        }

        // Return an array containing labels and corresponding percentage data
        return [
            'label' => $label,
            'data' => $data,
        ];
    }

}
