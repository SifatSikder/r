<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationSectors;
use App\Models\FairDecisionSectors;
use App\Models\User;
use App\Repositories\Admin\MediaRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PortalController extends BaseController
{
    /**
     * Retrieve evaluations for the current user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_evaluations()
    {
        try {
            // Fetch evaluations for the current user and order them by creation date
            $evaluations = Evaluation::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get()->toArray();

            // Process and enrich evaluation data with sector and sub-sector information
            foreach ($evaluations as &$evaluation) {
                // Check and fetch sector information based on category
                if (isset($evaluation['evaluation_sector']) && $evaluation['evaluation_sector'] > 1) {
                    if ($evaluation['category'] == 'eta') {
                        $evaluation['eve_sector'] = EvaluationSectors::where('uid', $evaluation['evaluation_sector'])->first();
                    } else if ($evaluation['category'] == 'eta-fd') {
                        $evaluation['eve_sector'] = FairDecisionSectors::where('uid', $evaluation['evaluation_sector'])->first();
                    }
                }

                // Check and fetch sub-sector information based on category
                if (isset($evaluation['evaluation_sub_sector']) && $evaluation['evaluation_sub_sector'] > 1) {
                    if ($evaluation['category'] == 'eta') {
                        $evaluation['evaluation_sub_sector'] = EvaluationSectors::where('uid', $evaluation['evaluation_sector'])->first();
                    } else if ($evaluation['category'] == 'eta-fd') {
                        $evaluation['evaluation_sub_sector'] = FairDecisionSectors::where('uid', $evaluation['evaluation_sector'])->first();
                    }
                }
            }

            // Return JSON response with the enriched evaluation data
            return response()->json(['status' => 200, 'data' => $evaluations], 200);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['status' => 500, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile_update_action(Request $request)
    {
        try {
            // Validate input data for profile update
            $input = $request->input();
            $validator = Validator::make($input, [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|unique:users,email,' . Auth::id() . ',_id',
            ]);

            // Return validation error response if validation fails
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()]);
            }

            // Initialize avatar path to null
            $input['avatar'] = null;

            // Upload avatar if provided in the request
            if (!empty($request->file)) {
                $file = MediaRepository::Upload($request);
                if ($file['status'] == 200) {
                    $input['avatar'] = $file['data']['file_path'];
                }
            }

            // Update user profile information
            $user = User::where('_id', Auth::id())->first();
            $user->first_name = $input['first_name'];
            $user->last_name = $input['last_name'];
            $user->email = $input['email'];
            $user->avatar = $input['avatar'] != null ? $input['avatar'] : $user->avatar;
            $user->phone = $input['phone'] ?? null;
            $user->company = $input['company'] ?? null;
            $user->website = $input['website'] ?? null;
            $user->save();

            // Return success response
            return response()->json(['status' => 200, 'msg' => 'Profile has been updated successfully']);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile_update_password_action(Request $request)
    {
        try {
            // Validate input data for password update
            $input = $request->input();
            $validator = Validator::make($input, [
                'current_password' => 'required|min:6',
                'password' => 'required|confirmed|min:6',
            ]);

            // Return validation error response if validation fails
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()]);
            }

            // Fetch the current authenticated user
            $user = User::where('_id', Auth::id())->first();

            // Check if the current password is correct
            if (!Hash::check($input['current_password'], $user->password)) {
                return response()->json(['status' => 500, 'error' => ['current_password' => ['Password is not correct!']]]);
            }

            // Update user password
            $user->password = bcrypt($input['password']);
            $user->save();

            // Return success response
            return response()->json(['status' => 200, 'msg' => 'Password has been updated successfully']);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }
}
