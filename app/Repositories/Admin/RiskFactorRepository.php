<?php

namespace App\Repositories\Admin;

use App\Models\RiskFactors;
use Illuminate\Support\Facades\Validator;

class RiskFactorRepository
{
    /**
     * Retrieves all risk factors based on the provided keyword.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function GetAll($request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'keyword' => 'nullable'
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Fetch risk factors based on the provided keyword
            $riskFactors = RiskFactors::where(function ($q) use ($request) {
                if (!empty($request->keyword)) {
                    $q->where('title', 'LIKE', '%' . $request->keyword . '%');
                }
            })->get();

            // Return success response with data
            return ['status' => 200, 'data' => $riskFactors];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Manages the update of risk factors with the provided data.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function Manage($request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'risk_factors' => 'required|array',
                'risk_factors.*.title' => 'required',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Truncate the RiskFactors table
            RiskFactors::truncate();

            // Prepare and insert new risk factors
            $risk_factors = [];
            foreach ($input['risk_factors'] as $k => $risk_factor) {
                $risk_factors[] = [
                    'uid' => ($k + 1),
                    'title' => $risk_factor['title'],
                    'software' => $risk_factor['software'] ?? 0,
                    'hardware' => $risk_factor['hardware'] ?? 0,
                    'ethical' => $risk_factor['ethical'] ?? 0,
                    'legal' => $risk_factor['legal'] ?? 0,
                ];
            }
            RiskFactors::insert($risk_factors);

            // Return success response
            return ['status' => 200, 'msg' => 'Risk Factors are updated successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }
}
