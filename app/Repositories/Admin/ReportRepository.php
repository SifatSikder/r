<?php

namespace App\Repositories\Admin;

use App\Models\Evaluation;
use App\Models\EvaluationSectors;
use App\Models\FairDecisionSectors;
use App\Models\User;
use Carbon\Carbon;

class ReportRepository
{
    /**
     * Array containing predefined colors for various purposes.
     *
     * @var array
     */
    public static $Colors = [
        '#05c46b', '#485460', '#575fcf', '#0fbcf9', '#ffa801',
        '#006266', '#6F1E51', '#5758BB', '#1B1464', '#B53471',
        '#1289A7', '#EE5A24', '#ED4C67', '#1e90ff', '#57606f'
    ];


    /**
     * Generate an evaluation report for a specified date or the current month.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function evaluation_report($request): array
    {
        try {
            // Extract selected date or default to the first day of the current month
            $selected_date = $request->selected_date ?? date('Y-m-01');

            // Calculate the start dates for each week of the month
            $first_week_start = date('Y-m-01', strtotime($selected_date));
            $second_week_start = date('Y-m-d', strtotime('+7 days', strtotime($first_week_start)));
            $third_week_start = date('Y-m-d', strtotime('+7 days', strtotime($second_week_start)));
            $forth_week_start = date('Y-m-d', strtotime('+7 days', strtotime($third_week_start)));
            $last_day_of_month = date('Y-m-t', strtotime($first_week_start));
            $monthName = date('M', strtotime($first_week_start));

            // Define labels for each week in the report
            $evaluationLabels = ['1st Week, ' . $monthName, '2nd Week, ' . $monthName, '3rd Week, ' . $monthName, '4th Week, ' . $monthName];

            // Initialize an array to store evaluation data for different sectors
            $evaluationSectors = [];

            // General sector
            $evaluationSectors[] = [
                'name' => 'General',
                'color' => self::$Colors[0],
                'evaluations' => [
                    Evaluation::where('category', 'et')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($first_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($second_week_start)))->count(),
                    Evaluation::where('category', 'et')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($second_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($third_week_start)))->count(),
                    Evaluation::where('category', 'et')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($third_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($forth_week_start)))->count(),
                    Evaluation::where('category', 'et')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($forth_week_start)))->where('created_at', '<=', Carbon::createFromTimestamp(strtotime($last_day_of_month)))->count(),
                ],
            ];

            // Non-Technical sector
            $evaluationSectors[] = [
                'name' => 'Non Technical',
                'color' => self::$Colors[1],
                'evaluations' => [
                    Evaluation::where('category', 'nt')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($first_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($second_week_start)))->count(),
                    Evaluation::where('category', 'nt')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($second_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($third_week_start)))->count(),
                    Evaluation::where('category', 'nt')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($third_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($forth_week_start)))->count(),
                    Evaluation::where('category', 'nt')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($forth_week_start)))->where('created_at', '<=', Carbon::createFromTimestamp(strtotime($last_day_of_month)))->count(),
                ],
            ];

            // Specific evaluation sectors
            $specificDomains = EvaluationSectors::where('parent_id', 0)->where('is_active', 1)->get()->toArray();
            foreach ($specificDomains as $k => $domain) {
                $evaluationSectors[] = [
                    'name' => $domain['title'],
                    'color' => self::$Colors[$k + 2],
                    'evaluations' => [
                        Evaluation::where('category', 'eta')->where('evaluation_sector', $domain['uid'])->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($first_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($second_week_start)))->count(),
                        Evaluation::where('category', 'eta')->where('evaluation_sector', $domain['uid'])->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($second_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($third_week_start)))->count(),
                        Evaluation::where('category', 'eta')->where('evaluation_sector', $domain['uid'])->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($third_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($forth_week_start)))->count(),
                        Evaluation::where('category', 'eta')->where('evaluation_sector', $domain['uid'])->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($forth_week_start)))->where('created_at', '<=', Carbon::createFromTimestamp(strtotime($last_day_of_month)))->count(),
                    ],
                ];
            }

            // Compile the report data
            $data = [
                'labels' => $evaluationLabels,
                'sectors' => $evaluationSectors,
            ];

            // Return the report data with success status
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }


    /**
     * Generate a fair decision report for a specified date or the current month.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function fair_decision_report($request): array
    {
        try {
            // Extract selected date or default to the first day of the current month
            $selected_date = $request->selected_date ?? date('Y-m-01');

            // Calculate the start dates for each week of the month
            $first_week_start = date('Y-m-01', strtotime($selected_date));
            $second_week_start = date('Y-m-d', strtotime('+7 days', strtotime($first_week_start)));
            $third_week_start = date('Y-m-d', strtotime('+7 days', strtotime($second_week_start)));
            $forth_week_start = date('Y-m-d', strtotime('+7 days', strtotime($third_week_start)));
            $last_day_of_month = date('Y-m-t', strtotime($first_week_start));
            $monthName = date('M', strtotime($first_week_start));

            // Define labels for each week in the report
            $evaluationLabels = ['1st Week, ' . $monthName, '2nd Week, ' . $monthName, '3rd Week, ' . $monthName, '4th Week, ' . $monthName];

            // Initialize an array to store evaluation data for different sectors
            $evaluationSectors = [];

            // General sector
            $evaluationSectors[] = [
                'name' => 'General',
                'color' => self::$Colors[0],
                'evaluations' => [
                    Evaluation::where('category', 'fd')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($first_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($second_week_start)))->count(),
                    Evaluation::where('category', 'fd')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($second_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($third_week_start)))->count(),
                    Evaluation::where('category', 'fd')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($third_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($forth_week_start)))->count(),
                    Evaluation::where('category', 'fd')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($forth_week_start)))->where('created_at', '<=', Carbon::createFromTimestamp(strtotime($last_day_of_month)))->count(),
                ],
            ];

            // Specific fair decision sectors
            $specificDomains = FairDecisionSectors::where('parent_id', 0)->where('is_active', 1)->get()->toArray();
            foreach ($specificDomains as $k => $domain) {
                $evaluationSectors[] = [
                    'name' => $domain['title'],
                    'color' => self::$Colors[$k + 1],
                    'evaluations' => [
                        Evaluation::where('category', 'eta-fd')->where('evaluation_sector', $domain['uid'])->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($first_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($second_week_start)))->count(),
                        Evaluation::where('category', 'eta-fd')->where('evaluation_sector', $domain['uid'])->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($second_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($third_week_start)))->count(),
                        Evaluation::where('category', 'eta-fd')->where('evaluation_sector', $domain['uid'])->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($third_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($forth_week_start)))->count(),
                        Evaluation::where('category', 'eta-fd')->where('evaluation_sector', $domain['uid'])->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($forth_week_start)))->where('created_at', '<=', Carbon::createFromTimestamp(strtotime($last_day_of_month)))->count(),
                    ],
                ];
            }

            // Compile the report data
            $data = [
                'labels' => $evaluationLabels,
                'sectors' => $evaluationSectors,
            ];

            // Return the report data with success status
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }


    /**
     * Generate a report on registered users for a specified date or the current month.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function registered_users_report($request): array
    {
        try {
            // Extract selected date or default to the first day of the current month
            $selected_date = $request->selected_date ?? date('Y-m-01');

            // Calculate the start dates for each week of the month
            $first_week_start = date('Y-m-01', strtotime($selected_date));
            $second_week_start = date('Y-m-d', strtotime('+7 days', strtotime($first_week_start)));
            $third_week_start = date('Y-m-d', strtotime('+7 days', strtotime($second_week_start)));
            $forth_week_start = date('Y-m-d', strtotime('+7 days', strtotime($third_week_start)));
            $last_day_of_month = date('Y-m-t', strtotime($first_week_start));
            $monthName = date('M', strtotime($first_week_start));

            // Define labels for each week in the report
            $reportLabels = ['1st Week, ' . $monthName, '2nd Week, ' . $monthName, '3rd Week, ' . $monthName, '4th Week, ' . $monthName];

            // Initialize an array to store user registration data for different subscription types
            $userReport = [];

            // Premium Users
            $userReport[] = [
                'name' => 'Premium Users',
                'color' => self::$Colors[0],
                'registered' => [
                    User::where('subscription_type', 'premium')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($first_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($second_week_start)))->count(),
                    User::where('subscription_type', 'premium')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($second_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($third_week_start)))->count(),
                    User::where('subscription_type', 'premium')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($third_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($forth_week_start)))->count(),
                    User::where('subscription_type', 'premium')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($forth_week_start)))->where('created_at', '<=', Carbon::createFromTimestamp(strtotime($last_day_of_month)))->count(),
                ],
            ];

            // Free Users
            $userReport[] = [
                'name' => 'Free Users',
                'color' => self::$Colors[1],
                'registered' => [
                    User::where('subscription_type', '!=', 'premium')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($first_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($second_week_start)))->count(),
                    User::where('subscription_type', '!=', 'premium')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($second_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($third_week_start)))->count(),
                    User::where('subscription_type', '!=', 'premium')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($third_week_start)))->where('created_at', '<', Carbon::createFromTimestamp(strtotime($forth_week_start)))->count(),
                    User::where('subscription_type', '!=', 'premium')->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($forth_week_start)))->where('created_at', '<=', Carbon::createFromTimestamp(strtotime($last_day_of_month)))->count(),
                ],
            ];

            // Compile the report data
            $data = [
                'labels' => $reportLabels,
                'users' => $userReport,
            ];

            // Return the report data with success status
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

}
