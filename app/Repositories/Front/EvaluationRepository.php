<?php

namespace App\Repositories\Front;

use App\Helpers;
use App\Models\Evaluation;
use App\Models\EvaluationSectors;
use App\Models\FairDecisionSectors;
use App\Models\QuestionGroups;
use App\Models\Questionnaires;
use App\Models\RiskFactors;
use App\Models\RiskMatrix;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EvaluationRepository
{
    /**
     * Perform risk evaluation for a given evaluation ID.
     *
     * @param string $evaluation_id
     * @return array
     */
    public static function riskEvaluation($evaluation_id)
    {
        // Get the authenticated user's ID
        $user_id = Auth::id();

        // Retrieve the evaluation for the specified user and ID
        $evaluation = Evaluation::where('user_id', $user_id)->where('_id', $evaluation_id)->first();

        // Initialize the result array with the evaluation
        $rv['evaluation'] = $evaluation;

        // Perform risk evaluation based on the evaluation category
        if ($evaluation['category'] == 'et') {
            $rv['riskReport'] = self::etRiskReport($evaluation);
        } elseif ($evaluation['category'] == 'eta') {
            $rv['riskReport'] = self::etaRiskReport($evaluation);

            // Fetch additional information for evaluation sectors
            $rv['evaluation']['evaluation_sector'] = EvaluationSectors::where('parent_id', 0)
                ->where('uid', (int)$rv['evaluation']['evaluation_sector'])
                ->first();
            $rv['evaluation']['evaluation_sub_sector'] = EvaluationSectors::where('parent_id', (int)$rv['evaluation']['evaluation_sector']['uid'])
                ->where('uid', (int)$rv['evaluation']['evaluation_sub_sector'])
                ->first();
        } elseif ($evaluation['category'] == 'eta-fd') {
            $rv['riskReport'] = self::etaFdRiskReport($evaluation);

            // Fetch additional information for fair decision sectors
            $rv['evaluation']['evaluation_sector'] = FairDecisionSectors::where('parent_id', 0)
                ->where('uid', (int)$rv['evaluation']['evaluation_sector'])
                ->first();
            $rv['evaluation']['evaluation_sub_sector'] = FairDecisionSectors::where('parent_id', (int)$rv['evaluation']['evaluation_sector']['uid'])
                ->where('uid', (int)$rv['evaluation']['evaluation_sub_sector'])
                ->first();
        } elseif ($evaluation['category'] == 'nt') {
            $rv['riskReport'] = self::ntRiskReport($evaluation);
        } elseif ($evaluation['category'] == 'fd') {
            $rv['riskReport'] = self::fdRiskReport($evaluation);
        } else {
            $rv['riskReport'] = null;
        }

        // Update the evaluation with the generated risk report
        $evaluationReport = $rv['riskReport'];
        Evaluation::where('_id', $evaluation_id)->update([
            'report' => $evaluationReport
        ]);

        // Return the result array
        return $rv;
    }

    /**
     * Calculate the risk report for the Evaluation Tool category.
     *
     * @param string $evaluation_id - The ID of the evaluation.
     * @return array - Array containing the final risk report.
     */
    public static function etRiskReport($evaluation)
    {
        // Initialize an array to store information about domains.
        $domains = [];

        // Loop through each answer in the evaluation to identify domains.
        foreach ($evaluation['answers'] as $domainID => $answer) {
            $group_uid = str_replace('domain_', '', $domainID);
            $group = QuestionGroups::where('uid', (int)$group_uid)->first();
            $domains[] = $group->toArray();
        }

        // Loop through each identified domain to calculate risk report.
        foreach ($domains as &$domain) {
            // Check if answers for the current domain are not null.
            if ($evaluation['answers']['domain_' . $domain['uid']] != null) {
                // Arrange and Group answers by Questions.
                $qSet = [];
                foreach ($evaluation['answers']['domain_' . $domain['uid']] as $sq => $sr) {
                    $qId = substr($sq, 0, strpos($sq, "_"));
                    if (!isset($qSet[$qId])) {
                        $qSet[$qId] = [];
                    }
                    $qSet[$qId][] = $sr;
                }

                // Calculate Risk for each Question.
                $sl = 0;
                $SectionQuestions = [];
                $SectionQuestionsRiskLevel = [];
                foreach ($qSet as $eachQSet) {
                    $sl++;
                    $riskFactors = 0;
                    $riskMembership = 0;
                    foreach ($eachQSet as $qSetV) {
                        $riskFactors = $riskFactors + ((float)$qSetV * $domain['weight']);
                        $riskMembership = $riskMembership + $domain['weight'];
                    }
                    $SectionQuestions['q' . $sl] = Helpers::num2format($riskFactors / $riskMembership);
                    $SectionQuestionsRiskLevel['q' . $sl] = Evaluation::riskToLevel($SectionQuestions['q' . $sl]);
                }

                // Calculate Risk for each Section.
                $riskFactors = 0;
                $riskMembership = 0;
                foreach ($SectionQuestions as $eachQRisk) {
                    $riskFactors = $riskFactors + ((float)$eachQRisk * $domain['weight']);
                    $riskMembership = $riskMembership + $domain['weight'];
                }
                $SectionRisk = Helpers::num2format($riskFactors / $riskMembership);

                // Store the risk report for the current domain.
                $domain['risk_report'] = [
                    'Risk' => $SectionRisk,
                    'RiskLevel' => Evaluation::riskToLevel($SectionRisk),
                    'questionRisk' => $SectionQuestions,
                    'questionRiskLevel' => $SectionQuestionsRiskLevel,
                ];
            }
        }

        // Calculate Final Risk across all domains.
        $riskFactors = 0;
        $riskMembership = 0;
        $TotalRiskValues = 0;
        foreach ($domains as $dmn) {
            if (isset($dmn['risk_report'])) {
                $TotalRiskValues = $TotalRiskValues + (float)$dmn['risk_report']['Risk'];
                $riskFactors = $riskFactors + ((float)$dmn['risk_report']['Risk'] * $dmn['weight']);
                $riskMembership = $riskMembership + $dmn['weight'];
            }
        }

        // Calculate Risk Percentages for each domain.
        foreach ($domains as &$dm) {
            if (isset($dmn['risk_report'])) {
                $dm['risk_report']['risk_percentage'] = Helpers::num2format(($dm['risk_report']['Risk'] / $TotalRiskValues) * 100);
                $dm['risk_report']['risk_color'] = Evaluation::levelToColor($dm['risk_report']['Risk']);
            }
        }

        // Initialize Risk Counter.
        $RiskCounter = ['Low' => 0, 'Limited' => 0, 'High' => 0, 'No' => 0];

        // Count the number of risks at each level.
        foreach ($domains as $rc) {
            if (isset($rc['risk_report'])) {
                foreach ($rc['risk_report']['questionRiskLevel'] as $ql) {
                    if ($ql == 'Low') {
                        $RiskCounter['Low']++;
                    } else if ($ql == 'Limited') {
                        $RiskCounter['Limited']++;
                    } else if ($ql == 'High') {
                        $RiskCounter['High']++;
                    } else if ($ql == 'No') {
                        $RiskCounter['No']++;
                    }
                }
            }
        }

        // Calculate Risk Percentages for the entire evaluation.
        $RiskTotal = $RiskCounter['Low'] + $RiskCounter['Limited'] + $RiskCounter['High'] + $RiskCounter['No'];
        $RiskPercentage = [
            'Low' => round(Helpers::num2format(($RiskCounter['Low'] / $RiskTotal) * 100)),
            'Limited' => round(Helpers::num2format(($RiskCounter['Limited'] / $RiskTotal) * 100)),
            'High' => round(Helpers::num2format(($RiskCounter['High'] / $RiskTotal) * 100)),
            'No' => round(Helpers::num2format(($RiskCounter['No'] / $RiskTotal) * 100))
        ];

        // Final Risk Result.
        $rv = [];
        $rv['finalRisk'] = Helpers::num2format($riskFactors / $riskMembership);
        $rv['finalRiskLevel'] = Evaluation::riskToLevel($rv['finalRisk']);
        $rv['sections'] = $domains;
        $rv['riskCounter'] = $RiskCounter;
        $rv['riskPercentage'] = $RiskPercentage;

        // Additional processing for premium users.
        $user = User::where('_id', Auth::id())->first();
        if ($user->subscription_type == 'premium') {
            // Check if chatGPT information is not available in the evaluation report.
            if (!isset($evaluation->report['chatGPT']) || $evaluation->report['chatGPT'] == null) {
                // Prepare a question for ChatGPT based on the evaluation results.
                $questionGPT = 'I am using a Risk evaluation system for AI systems. ';
                $questionGPT .= 'I did make an evaluation as technology uses falls under the ';
                $questionGPT .= $rv['finalRiskLevel'];
                $questionGPT .= ' Risk level. ';
                $qGroups = QuestionGroups::whereNull('domain')->get()->toArray();
                foreach ($qGroups as $qGroup) {
                    $domainEt = 'domain_' . $qGroup['uid'];
                    $questions = Questionnaires::where('group', $qGroup['title'])->where('category', 'et')->get()->toArray();
                    foreach ($questions as $k => $question) {
                        if ($evaluation->answers[$domainEt] != null) {
                            $questionGPT .= 'For Question ' . ($k + 1) . ', ';
                            if ($question['option_1']['title'] != null) {
                                $questionGPT .= 'Firstly, for ';
                                $questionGPT .= $question['option_1']['title'];
                                $questionGPT .= ' I answer as ';
                                $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainEt][$question['_id'] . '_q1']);
                                $questionGPT .= ' which is showing ';
                                $questionGPT .= $question['option_1']['risk_level'];
                                $questionGPT .= ' risk in that system. ';
                            }
                            if ($question['option_2']['title'] != null) {
                                $questionGPT .= 'Secondly, for ';
                                $questionGPT .= $question['option_2']['title'];
                                $questionGPT .= ' I answer as ';
                                $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainEt][$question['_id'] . '_q2']);
                                $questionGPT .= ' which is showing ';
                                $questionGPT .= $question['option_2']['risk_level'];
                                $questionGPT .= ' risk in that system. ';
                            }
                            if ($question['option_3']['title'] != null) {
                                $questionGPT .= 'Thirdly, for ';
                                $questionGPT .= $question['option_3']['title'];
                                $questionGPT .= ' I answer as ';
                                $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainEt][$question['_id'] . '_q3']);
                                $questionGPT .= ' which is showing ';
                                $questionGPT .= $question['option_3']['risk_level'];
                                $questionGPT .= ' risk in that system. ';
                            }
                        }
                    }
                }
                $questionGPT .= ' Tell me why the risk level for this section is ' . $rv['finalRiskLevel'] . ' and what is the mitigation strategies? ';

                // Use ChatGPT to get additional insights based on the provided question.
                $rv['chatGPT'] = Helpers::askChatGPT($questionGPT);
            } else {
                // If chatGPT information is already available in the evaluation report, use it.
                $rv['chatGPT'] = $evaluation->report['chatGPT'];
            }
        }

        // Return the final risk report.
        return $rv;
    }

    public static function etaFdRiskReport($evaluation)
    {
        // Initialize an array to store information about domains.
        $sector = null;
        $domains = [];

        // Loop through each answer in the evaluation to identify domains.
        foreach ($evaluation['answers'] as $domainID => $answer) {
            $uids = str_replace('domain_', '', $domainID);
            $uids = explode('_', $uids);
            $sectorId = $uids[0];
            $subSectorId = $uids[1];
            $sector = FairDecisionSectors::where('uid', (int)$sectorId)->where('parent_id', 0)->first();
            $subSector = FairDecisionSectors::where('uid', (int)$subSectorId)->where('parent_id', (int)$sectorId)->first();
            $domains[] = $subSector->toArray();
        }


        // Loop through each identified domain to calculate risk report.
        foreach ($domains as &$domain) {
            $answerKey = 'domain_' . $domain['parent_id'] . '_' . $domain['uid'];
            // Check if answers for the current domain are not null.
            if ($evaluation['answers'][$answerKey] != null) {
                // Arrange and Group answers by Questions.
                $qSet = [];
                foreach ($evaluation['answers'][$answerKey] as $sq => $sr) {
                    $qId = substr($sq, 0, strpos($sq, "_"));
                    if (!isset($qSet[$qId])) {
                        $qSet[$qId] = [];
                    }
                    $qSet[$qId][] = $sr;
                }

                // Calculate Risk for each Question.
                $sl = 0;
                $SectionQuestions = [];
                $SectionQuestionsRiskLevel = [];
                foreach ($qSet as $eachQSet) {
                    $sl++;
                    $riskFactors = 0;
                    $riskMembership = 0;
                    foreach ($eachQSet as $qSetV) {
                        $riskFactors = $riskFactors + ((float)$qSetV * $domain['weight']);
                        $riskMembership = $riskMembership + $domain['weight'];
                    }
                    $SectionQuestions['q' . $sl] = Helpers::num2format($riskFactors / $riskMembership);
                    $SectionQuestionsRiskLevel['q' . $sl] = Evaluation::riskToLevel($SectionQuestions['q' . $sl]);
                }

                // Calculate Risk for each Section.
                $riskFactors = 0;
                $riskMembership = 0;
                foreach ($SectionQuestions as $eachQRisk) {
                    $riskFactors = $riskFactors + ((float)$eachQRisk * $domain['weight']);
                    $riskMembership = $riskMembership + $domain['weight'];
                }
                $SectionRisk = Helpers::num2format($riskFactors / $riskMembership);

                // Store the risk report for the current domain.
                $domain['risk_report'] = [
                    'Risk' => $SectionRisk,
                    'RiskLevel' => Evaluation::riskToLevel($SectionRisk),
                    'questionRisk' => $SectionQuestions,
                    'questionRiskLevel' => $SectionQuestionsRiskLevel,
                ];
            }
        }

        // Calculate Final Risk across all domains.
        $riskFactors = 0;
        $riskMembership = 0;
        $TotalRiskValues = 0;
        foreach ($domains as $dmn) {
            if (isset($dmn['risk_report'])) {
                $TotalRiskValues = $TotalRiskValues + (float)$dmn['risk_report']['Risk'];
                $riskFactors = $riskFactors + ((float)$dmn['risk_report']['Risk'] * $dmn['weight']);
                $riskMembership = $riskMembership + $dmn['weight'];
            }
        }

        // Calculate Risk Percentages for each domain.
        foreach ($domains as &$dm) {
            if (isset($dmn['risk_report'])) {
                $dm['risk_report']['risk_percentage'] = Helpers::num2format(($dm['risk_report']['Risk'] / $TotalRiskValues) * 100);
                $dm['risk_report']['risk_color'] = Evaluation::levelToColor($dm['risk_report']['Risk']);
            }
        }

        // Initialize Risk Counter.
        $RiskCounter = ['Low' => 0, 'Limited' => 0, 'High' => 0, 'No' => 0];

        // Count the number of risks at each level.
        foreach ($domains as $rc) {
            if (isset($rc['risk_report'])) {
                foreach ($rc['risk_report']['questionRiskLevel'] as $ql) {
                    if ($ql == 'Low') {
                        $RiskCounter['Low']++;
                    } else if ($ql == 'Limited') {
                        $RiskCounter['Limited']++;
                    } else if ($ql == 'High') {
                        $RiskCounter['High']++;
                    } else if ($ql == 'No') {
                        $RiskCounter['No']++;
                    }
                }
            }
        }

        // Calculate Risk Percentages for the entire evaluation.
        $RiskTotal = $RiskCounter['Low'] + $RiskCounter['Limited'] + $RiskCounter['High'] + $RiskCounter['No'];
        $RiskPercentage = [
            'Low' => round(Helpers::num2format(($RiskCounter['Low'] / $RiskTotal) * 100)),
            'Limited' => round(Helpers::num2format(($RiskCounter['Limited'] / $RiskTotal) * 100)),
            'High' => round(Helpers::num2format(($RiskCounter['High'] / $RiskTotal) * 100)),
            'No' => round(Helpers::num2format(($RiskCounter['No'] / $RiskTotal) * 100))
        ];

        // Final Risk Result.
        $rv = [];
        $rv['finalRisk'] = Helpers::num2format($riskFactors / $riskMembership);
        $rv['finalRiskLevel'] = Evaluation::riskToLevel($rv['finalRisk']);
        $rv['sections'] = $domains;
        $rv['riskCounter'] = $RiskCounter;
        $rv['riskPercentage'] = $RiskPercentage;

        // Additional processing for premium users.
        $user = User::where('_id', Auth::id())->first();
        if ($user->subscription_type == 'premium') {
            // Check if chatGPT information is not available in the evaluation report.
            if (!isset($evaluation->report['chatGPT']) || $evaluation->report['chatGPT'] == null) {
                // Prepare a question for ChatGPT based on the evaluation results.
                $questionGPT = 'I am using a Fair Decision analysis system for AI systems. ';
                $questionGPT .= 'I did make a Fair Decision analysis as technology uses falls under the ';
                $questionGPT .= $rv['finalRiskLevel'];
                $questionGPT .= ' Risk level. ';
                foreach ($domains as $qGroup) {
                    $domainEt = 'domain_' . $qGroup['parent_id'] . '_' . $qGroup['uid'];
                    $questions = Questionnaires::where('sector', (int)$qGroup['parent_id'])->where('sub_sector', (int)$qGroup['uid'])->where('category', 'eta-fd')->get()->toArray();
                    foreach ($questions as $k => $question) {
                        if ($evaluation->answers[$domainEt] != null) {
                            $questionGPT .= 'For Question ' . ($k + 1) . ', ';
                            if ($question['option_1']['title'] != null) {
                                $questionGPT .= 'Firstly, for ';
                                $questionGPT .= $question['option_1']['title'];
                                $questionGPT .= ' I answer as ';
                                $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainEt][$question['_id'] . '_q1']);
                                $questionGPT .= ' which is showing ';
                                $questionGPT .= $question['option_1']['risk_level'];
                                $questionGPT .= ' risk in that system. ';
                            }
                            if ($question['option_2']['title'] != null) {
                                $questionGPT .= 'Secondly, for ';
                                $questionGPT .= $question['option_2']['title'];
                                $questionGPT .= ' I answer as ';
                                $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainEt][$question['_id'] . '_q2']);
                                $questionGPT .= ' which is showing ';
                                $questionGPT .= $question['option_2']['risk_level'];
                                $questionGPT .= ' risk in that system. ';
                            }
                            if ($question['option_3']['title'] != null) {
                                $questionGPT .= 'Thirdly, for ';
                                $questionGPT .= $question['option_3']['title'];
                                $questionGPT .= ' I answer as ';
                                $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainEt][$question['_id'] . '_q3']);
                                $questionGPT .= ' which is showing ';
                                $questionGPT .= $question['option_3']['risk_level'];
                                $questionGPT .= ' risk in that system. ';
                            }
                        }
                    }
                }
                $questionGPT .= ' Tell me why the risk level for this section is ' . $rv['finalRiskLevel'] . ' and what is the mitigation strategies? ';

                // Use ChatGPT to get additional insights based on the provided question.
                $rv['chatGPT'] = Helpers::askChatGPT($questionGPT);
            } else {
                // If chatGPT information is already available in the evaluation report, use it.
                $rv['chatGPT'] = $evaluation->report['chatGPT'];
            }
        }

        // Return the final risk report.
        return $rv;
    }

    /**
     * Calculate the risk report for the Evaluation Tool Specific Domain category.
     *
     * @param array $evaluation - The evaluation data containing answers.
     * @return array - Array containing the final risk report.
     */
    public static function etaRiskReport($evaluation)
    {
        // Initialize variables to store sector, sub-sector, and domain information.
        $sector = null;
        $sub_sector = null;
        $domain = null;

        // Loop through each answer in the evaluation to extract sector, sub-sector, and domain.
        foreach ($evaluation['answers'] as $domainID => $answer) {
            $uids = str_replace('domain_', '', $domainID);
            if (strpos('_', $uids)) {
                $uids = explode('_', $uids);
                $sector = $uids[0];
                $sub_sector = $uids[1];
            } else {
                $sector = $uids;
            }
            $domain = $domainID;
        }

        // Calculate the weight for each question based on the total number of questions.
        $totalQuestions = Questionnaires::where('category', $evaluation['category'])
            ->where('sector', (int)$sector)
            ->where(function ($q) use ($sub_sector) {
                if ($sub_sector != null) {
                    $q->where('sub_sector', (int)$sub_sector);
                }
            })->count();
        $weight = 1 / $totalQuestions;

        // Arrange and Group answers by Questions.
        $qSet = [];
        foreach ($evaluation['answers'][$domain] as $sq => $sr) {
            $qId = substr($sq, 0, strpos($sq, "_"));
            if (!isset($qSet[$qId])) {
                $qSet[$qId] = [];
            }
            $qSet[$qId][] = $sr;
        }

        // Calculate Risk for each Question.
        $sl = 0;
        $SectionQuestions = [];
        $SectionQuestionsRiskLevel = [];
        foreach ($qSet as $eachQSet) {
            $sl++;
            $riskFactors = 0;
            $riskMembership = 0;
            foreach ($eachQSet as $qSetV) {
                $riskFactors = $riskFactors + ((float)$qSetV * $weight);
                $riskMembership = $riskMembership + $weight;
            }
            // Calculate and store risk for each question in the section.
            $SectionQuestions['q' . $sl] = Helpers::num2format($riskFactors / $riskMembership);
            $SectionQuestionsRiskLevel['q' . $sl] = Evaluation::riskToLevel($SectionQuestions['q' . $sl]);
        }

        // Calculate Risk for each Section.
        $riskFactors = 0;
        $riskMembership = 0;
        foreach ($SectionQuestions as $eachQRisk) {
            $riskFactors = $riskFactors + ((float)$eachQRisk * $weight);
            $riskMembership = $riskMembership + $weight;
        }
        // Calculate and store risk for the entire section.
        $SectionRisk = Helpers::num2format($riskFactors / $riskMembership);
        $risk_report = [
            'Risk' => $SectionRisk,
            'RiskLevel' => Evaluation::riskToLevel($SectionRisk),
            'questionRisk' => $SectionQuestions,
            'questionRiskLevel' => $SectionQuestionsRiskLevel,
        ];

        // Initialize Risk Counter.
        $RiskCounter = ['Low' => 0, 'Limited' => 0, 'High' => 0, 'No' => 0];
        foreach ($SectionQuestionsRiskLevel as $ql) {
            if ($ql == 'Low') {
                $RiskCounter['Low']++;
            } else if ($ql == 'Limited') {
                $RiskCounter['Limited']++;
            } else if ($ql == 'High') {
                $RiskCounter['High']++;
            } else if ($ql == 'No') {
                $RiskCounter['No']++;
            }
        }

        // Calculate Risk Percentages for the entire evaluation.
        $RiskTotal = $RiskCounter['Low'] + $RiskCounter['Limited'] + $RiskCounter['High'] + $RiskCounter['No'];
        $RiskPercentage = [
            'Low' => round(Helpers::num2format(($RiskCounter['Low'] / $RiskTotal) * 100)),
            'Limited' => round(Helpers::num2format(($RiskCounter['Limited'] / $RiskTotal) * 100)),
            'High' => round(Helpers::num2format(($RiskCounter['High'] / $RiskTotal) * 100)),
            'No' => round(Helpers::num2format(($RiskCounter['No'] / $RiskTotal) * 100))
        ];

        // Final Risk Result.
        $rv = [];
        $rv['finalRisk'] = $risk_report['Risk'];
        $rv['finalRiskLevel'] = $risk_report['RiskLevel'];
        $rv['risk_report'] = $risk_report;
        $rv['riskCounter'] = $RiskCounter;
        $rv['riskPercentage'] = $RiskPercentage;

        // Additional processing for premium users.
        $user = User::where('_id', Auth::id())->first();
        if ($user->subscription_type == 'premium') {
            if (!isset($evaluation->report['chatGPT']) || $evaluation->report['chatGPT'] == null) {
                $domainEta = 'domain_' . $evaluation->evaluation_sector;
                if ($evaluation->evaluation_sub_sector != null) {
                    $domainEta .= '_' . $evaluation->evaluation_sub_sector;
                }

                $questions = Questionnaires::whereIn('_id', array_keys($qSet))->get()->toArray();
                $questionGPT = 'I am using a Risk evaluation system for AI systems. ';
                $questionGPT .= 'I did make an evaluation where my technology uses in ' . $evaluation->title . '. domain falls under the ';
                $questionGPT .= $rv['finalRiskLevel'];
                $questionGPT .= ' Risk level. ';
                foreach ($questions as $k => $question) {
                    $questionGPT .= 'For Question ' . ($k + 1) . ', ';
                    if ($question['option_1']['title'] != null) {
                        $questionGPT .= 'Firstly, for ';
                        $questionGPT .= $question['option_1']['title'];
                        $questionGPT .= ' I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainEta][$question['_id'] . '_q1']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $question['option_1']['risk_level'];
                        $questionGPT .= ' risk in that system. ';
                    }
                    if ($question['option_2']['title'] != null) {
                        $questionGPT .= 'Secondly, for ';
                        $questionGPT .= $question['option_2']['title'];
                        $questionGPT .= ' I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainEta][$question['_id'] . '_q2']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $question['option_2']['risk_level'];
                        $questionGPT .= ' risk in that system. ';
                    }
                    if ($question['option_3']['title'] != null) {
                        $questionGPT .= 'Thirdly, for ';
                        $questionGPT .= $question['option_3']['title'];
                        $questionGPT .= ' I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainEta][$question['_id'] . '_q3']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $question['option_3']['risk_level'];
                        $questionGPT .= ' risk in that system. ';
                    }
                }
                $questionGPT .= ' Tell me why the risk level for this section is ' . $rv['finalRiskLevel'] . ' and what is the mitigation strategies? ';
                // Use ChatGPT to get additional insights based on the provided question.
                $rv['chatGPT'] = Helpers::askChatGPT($questionGPT);
            } else {
                // If chatGPT information is already available in the evaluation report, use it.
                $rv['chatGPT'] = $evaluation->report['chatGPT'];
            }
        }

        // Return the final risk report.
        return $rv;
    }

    /**
     * Calculate the risk report for the Non-Technology (NT) category.
     *
     * @param array $evaluation - The evaluation data containing answers.
     * @return array - Array containing the final risk report.
     */
    public static function ntRiskReport($evaluation)
    {
        // Calculate the weight for each question based on the total number of questions in the NT category.
        $totalQuestions = Questionnaires::where('category', 'nt')->count();
        $weight = 1 / $totalQuestions;

        // Arrange and Group answers by Questions.
        $qSet = [];
        foreach ($evaluation['answers']['nt'] as $sq => $sr) {
            $qId = substr($sq, 0, strpos($sq, "_"));
            if (!isset($qSet[$qId])) {
                $qSet[$qId] = [];
            }
            $qSet[$qId][] = $sr;
        }

        // Calculate Risk for each Question.
        $sl = 0;
        $SectionQuestions = [];
        $SectionQuestionsRiskLevel = [];
        foreach ($qSet as $eachQSet) {
            $sl++;
            $riskFactors = 0;
            $riskMembership = 0;
            foreach ($eachQSet as $qSetV) {
                $riskFactors = $riskFactors + ((float)$qSetV * $weight);
                $riskMembership = $riskMembership + $weight;
            }
            // Calculate and store risk for each question in the section.
            $SectionQuestions['q' . $sl] = Helpers::num2format($riskFactors / $riskMembership);
            $SectionQuestionsRiskLevel['q' . $sl] = Evaluation::riskToLevel($SectionQuestions['q' . $sl]);
        }

        // Calculate Risk for each Section.
        $riskFactors = 0;
        $riskMembership = 0;
        foreach ($SectionQuestions as $eachQRisk) {
            $riskFactors = $riskFactors + ((float)$eachQRisk * $weight);
            $riskMembership = $riskMembership + $weight;
        }
        // Calculate and store risk for the entire section.
        $SectionRisk = Helpers::num2format($riskFactors / $riskMembership);
        $risk_report = [
            'Risk' => $SectionRisk,
            'RiskLevel' => Evaluation::riskToLevel($SectionRisk),
            'questionRisk' => $SectionQuestions,
            'questionRiskLevel' => $SectionQuestionsRiskLevel,
        ];

        // RiskCounter
        $RiskCounter = ['Low' => 0, 'Limited' => 0, 'High' => 0, 'No' => 0];
        foreach ($SectionQuestionsRiskLevel as $ql) {
            if ($ql == 'Low') {
                $RiskCounter['Low']++;
            } else if ($ql == 'Limited') {
                $RiskCounter['Limited']++;
            } else if ($ql == 'High') {
                $RiskCounter['High']++;
            } else if ($ql == 'No') {
                $RiskCounter['No']++;
            }
        }

        // RiskPercentage
        $RiskTotal = $RiskCounter['Low'] + $RiskCounter['Limited'] + $RiskCounter['High'] + $RiskCounter['No'];
        $RiskPercentage = [
            'Low' => round(Helpers::num2format(($RiskCounter['Low'] / $RiskTotal) * 100)),
            'Limited' => round(Helpers::num2format(($RiskCounter['Limited'] / $RiskTotal) * 100)),
            'High' => round(Helpers::num2format(($RiskCounter['High'] / $RiskTotal) * 100)),
            'No' => round(Helpers::num2format(($RiskCounter['No'] / $RiskTotal) * 100))
        ];

        // Final Risk Result.
        $rv = [];
        $rv['finalRisk'] = $risk_report['Risk'];
        $rv['finalRiskLevel'] = $risk_report['RiskLevel'];
        $rv['risk_report'] = $risk_report;
        $rv['riskCounter'] = $RiskCounter;
        $rv['riskPercentage'] = $RiskPercentage;

        // Additional processing for premium users.
        $user = User::where('_id', Auth::id())->first();
        if ($user->subscription_type == 'premium') {
            if (!isset($evaluation->report['chatGPT']) || $evaluation->report['chatGPT'] == null) {
                $domainNt = 'nt';
                $questions = Questionnaires::whereIn('_id', array_keys($qSet))->where('category', 'nt')->get()->toArray();
                $questionGPT = 'I am using a Risk evaluation system for AI systems. ';
                $questionGPT .= 'I did make an evaluation as non-technology uses fall under the ';
                $questionGPT .= $rv['finalRiskLevel'];
                $questionGPT .= ' Risk level. ';
                foreach ($questions as $k => $question) {
                    $questionGPT .= 'For Question ' . ($k + 1) . ', ';
                    if ($question['option_1']['title'] != null) {
                        $questionGPT .= 'Firstly, for ';
                        $questionGPT .= $question['option_1']['title'];
                        $questionGPT .= ' I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainNt][$question['_id'] . '_q1']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $risk_report['questionRiskLevel']['q' . ($k + 1)];
                        $questionGPT .= ' risk in that system. ';
                    }
                    if ($question['option_2']['title'] != null) {
                        $questionGPT .= 'Secondly, for ';
                        $questionGPT .= $question['option_2']['title'];
                        $questionGPT .= ' I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainNt][$question['_id'] . '_q2']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $risk_report['questionRiskLevel']['q' . ($k + 1)];
                        $questionGPT .= ' risk in that system. ';
                    }
                    if ($question['option_3']['title'] != null) {
                        $questionGPT .= 'Thirdly, for ';
                        $questionGPT .= $question['option_3']['title'];
                        $questionGPT .= ' I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainNt][$question['_id'] . '_q3']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $risk_report['questionRiskLevel']['q' . ($k + 1)];
                        $questionGPT .= ' risk in that system. ';
                    }
                }
                $questionGPT .= ' Tell me why the risk level for this section is ' . $rv['finalRiskLevel'] . ' and what are the mitigation strategies? ';
                $rv['chatGPT'] = Helpers::askChatGPT($questionGPT);
            } else {
                $rv['chatGPT'] = $evaluation->report['chatGPT'];
            }
        }

        // Return the final risk report.
        return $rv;
    }

    /**
     * Calculate the risk report for the Fair Decision (FD) category.
     *
     * @param array $evaluation - The evaluation data containing answers.
     * @return array - Array containing the final risk report.
     */
    public static function fdRiskReport($evaluation)
    {
        // Calculate the weight for each question based on the total number of questions in the FD category.
        $totalQuestions = Questionnaires::where('category', 'fd')->count();
        $weight = 1 / $totalQuestions;

        // Arrange and Group answers by Questions.
        $qSet = [];
        foreach ($evaluation['answers']['fd'] as $sq => $sr) {
            $qId = substr($sq, 0, strpos($sq, "_"));
            if (!isset($qSet[$qId])) {
                $qSet[$qId] = [];
            }
            $qSet[$qId][] = $sr;
        }

        // Calculate Risk for each Question.
        $sl = 0;
        $SectionQuestions = [];
        $SectionQuestionsRiskLevel = [];
        foreach ($qSet as $eachQSet) {
            $sl++;
            $riskFactors = 0;
            $riskMembership = 0;
            foreach ($eachQSet as $qSetV) {
                $riskFactors = $riskFactors + ((float)$qSetV * $weight);
                $riskMembership = $riskMembership + $weight;
            }
            // Calculate and store risk for each question in the section.
            $SectionQuestions['q' . $sl] = Helpers::num2format($riskFactors / $riskMembership);
            $SectionQuestionsRiskLevel['q' . $sl] = Evaluation::riskToLevel($SectionQuestions['q' . $sl]);
        }

        // Calculate Risk for each Section.
        $riskFactors = 0;
        $riskMembership = 0;
        foreach ($SectionQuestions as $eachQRisk) {
            $riskFactors = $riskFactors + ((float)$eachQRisk * $weight);
            $riskMembership = $riskMembership + $weight;
        }
        // Calculate and store risk for the entire section.
        $SectionRisk = Helpers::num2format($riskFactors / $riskMembership);
        $risk_report = [
            'Risk' => $SectionRisk,
            'RiskLevel' => Evaluation::riskToLevel($SectionRisk),
            'questionRisk' => $SectionQuestions,
            'questionRiskLevel' => $SectionQuestionsRiskLevel,
        ];

        // RiskCounter
        $RiskCounter = ['Low' => 0, 'Limited' => 0, 'High' => 0, 'No' => 0];
        foreach ($SectionQuestionsRiskLevel as $ql) {
            if ($ql == 'Low') {
                $RiskCounter['Low']++;
            } else if ($ql == 'Limited') {
                $RiskCounter['Limited']++;
            } else if ($ql == 'High') {
                $RiskCounter['High']++;
            } else if ($ql == 'No') {
                $RiskCounter['No']++;
            }
        }

        // RiskPercentage
        $RiskTotal = $RiskCounter['Low'] + $RiskCounter['Limited'] + $RiskCounter['High'] + $RiskCounter['No'];
        $RiskPercentage = [
            'Low' => round(Helpers::num2format(($RiskCounter['Low'] / $RiskTotal) * 100)),
            'Limited' => round(Helpers::num2format(($RiskCounter['Limited'] / $RiskTotal) * 100)),
            'High' => round(Helpers::num2format(($RiskCounter['High'] / $RiskTotal) * 100)),
            'No' => round(Helpers::num2format(($RiskCounter['No'] / $RiskTotal) * 100))
        ];

        // Final Risk Result.
        $rv = [];
        $rv['finalRisk'] = $risk_report['Risk'];
        $rv['finalRiskLevel'] = $risk_report['RiskLevel'];
        $rv['risk_report'] = $risk_report;
        $rv['riskCounter'] = $RiskCounter;
        $rv['riskPercentage'] = $RiskPercentage;

        // Additional processing for premium users.
        $user = User::where('_id', Auth::id())->first();
        if ($user->subscription_type == 'premium') {
            if (!isset($evaluation->report['chatGPT']) || $evaluation->report['chatGPT'] == null) {
                $domainFd = 'fd';
                $questions = Questionnaires::whereIn('_id', array_keys($qSet))->where('category', 'fd')->get()->toArray();
                $questionGPT = 'I am using a Risk evaluation system for AI systems. ';
                $questionGPT .= 'I did make an evaluation for the Financial Domain as it falls under the ';
                $questionGPT .= $rv['finalRiskLevel'];
                $questionGPT .= ' Risk level. ';
                foreach ($questions as $k => $question) {
                    $questionGPT .= 'For Question ' . ($k + 1) . ', ';
                    if ($question['option_1']['title'] != null) {
                        $questionGPT .= 'Firstly, for ';
                        $questionGPT .= $question['option_1']['title'];
                        $questionGPT .= ' I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainFd][$question['_id'] . '_q1']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $risk_report['questionRiskLevel']['q' . ($k + 1)];
                        $questionGPT .= ' risk in that system. ';
                    }
                    if ($question['option_2']['title'] != null) {
                        $questionGPT .= 'Secondly, for ';
                        $questionGPT .= $question['option_2']['title'];
                        $questionGPT .= ' I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainFd][$question['_id'] . '_q2']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $risk_report['questionRiskLevel']['q' . ($k + 1)];
                        $questionGPT .= ' risk in that system. ';
                    }
                    if ($question['option_3']['title'] != null) {
                        $questionGPT .= 'Thirdly, for ';
                        $questionGPT .= $question['option_3']['title'];
                        $questionGPT .= ' I answer as ';
                        $questionGPT .= Questionnaires::getMarksToAns($evaluation->answers[$domainFd][$question['_id'] . '_q3']);
                        $questionGPT .= ' which is showing ';
                        $questionGPT .= $risk_report['questionRiskLevel']['q' . ($k + 1)];
                        $questionGPT .= ' risk in that system. ';
                    }
                }
                $questionGPT .= ' Tell me why the risk level for this section is ' . $rv['finalRiskLevel'] . ' and what are the mitigation strategies? ';
                $rv['chatGPT'] = Helpers::askChatGPT($questionGPT);
            } else {
                $rv['chatGPT'] = $evaluation->report['chatGPT'];
            }
        }

        // Return the final risk report.
        return $rv;
    }

}
