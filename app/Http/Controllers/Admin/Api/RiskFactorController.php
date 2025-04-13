<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\RiskFactorRepository;
use Illuminate\Http\Request;

class RiskFactorController extends Controller
{
    /**
     * Get all risk factors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetAll(Request $request)
    {
        // Call the GetAll method from RiskFactorRepository to retrieve all risk factors.
        $rv = RiskFactorRepository::GetAll($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Manage risk factors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Manage(Request $request)
    {
        // Call the Manage method from RiskFactorRepository to handle the management of risk factors.
        $rv = RiskFactorRepository::Manage($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }
}
