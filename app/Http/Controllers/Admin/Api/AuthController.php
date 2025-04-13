<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Handle Admin login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Login(Request $request)
    {
        // Call the Login method from AuthRepository to handle Admin login.
        $rv = AuthRepository::Login($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Handle Admin logout.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Logout(Request $request)
    {
        // Call the Logout method from AuthRepository to handle Admin logout.
        $rv = AuthRepository::Logout($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Handle password reset request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Forgot(Request $request)
    {
        // Call the Forgot method from AuthRepository to handle password reset request.
        $rv = AuthRepository::Forgot($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Handle password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Reset(Request $request)
    {
        // Call the Reset method from AuthRepository to handle password reset.
        $rv = AuthRepository::Reset($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Get Admin profile information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetProfile(Request $request)
    {
        // Call the GetProfile method from AuthRepository to retrieve Admin profile information.
        $rv = AuthRepository::GetProfile($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Update Admin profile information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function UpdateProfile(Request $request)
    {
        // Call the UpdateProfile method from AuthRepository to update Admin profile information.
        $rv = AuthRepository::UpdateProfile($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Handle password change request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ChangePassword(Request $request)
    {
        // Call the ChangePassword method from AuthRepository to handle password change request.
        $rv = AuthRepository::ChangePassword($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }
}
