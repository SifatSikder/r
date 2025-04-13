<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\ReportRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    /**
     * Generate and return an evaluation report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluation_report(Request $request): JsonResponse
    {
        // Delegate report generation to the ReportRepository
        $rv = ReportRepository::evaluation_report($request);

        // Return the report as a JSON response
        return response()->json($rv, 200);
    }

    /**
     * Generate and return a fair decision report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fair_decision_report(Request $request): JsonResponse
    {
        // Delegate report generation to the ReportRepository
        $rv = ReportRepository::fair_decision_report($request);

        // Return the report as a JSON response
        return response()->json($rv, 200);
    }

    /**
     * Generate and return a report on registered users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registered_users_report(Request $request): JsonResponse
    {
        // Delegate report generation to the ReportRepository
        $rv = ReportRepository::registered_users_report($request);

        // Return the report as a JSON response
        return response()->json($rv, 200);
    }
}
