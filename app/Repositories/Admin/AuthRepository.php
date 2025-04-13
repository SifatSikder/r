<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthRepository
{
    /**
     * Authenticates an admin user based on the provided credentials.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public static function Login($request)
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate input data
            $validator = Validator::make($input, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Retrieve admin information based on the provided email
            $adminInfo = Admin::where('email', $input['email'])->first();

            // Check if admin with the provided email exists
            if ($adminInfo == null) {
                return ['status' => 500, 'error' => ['email' => ['Email is not exist. Please re-check your email address.']]];
            }

            // Check if the provided password matches the hashed password in the database
            if (Hash::check($input['password'], $adminInfo['password'])) {
                $credential = [
                    'email' => $input['email'],
                    'password' => $input['password']
                ];

                // Attempt to log in the admin user using the provided credentials
                $remember = isset($input['remember']) && $input['remember'] == 1 ? true : false;
                if (Auth::guard('admin')->attempt($credential, $remember)) {
                    return ['status' => 200, 'msg' => 'Login Successful!'];
                } else {
                    return ['status' => 500, 'error' => ['email' => 'Invalid credentials! Please try again.']];
                }
            } else {
                return ['status' => 500, 'error' => ['password' => ['Invalid credentials! Please try again.']]];
            }
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Logs out the authenticated admin user.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public static function Logout($request)
    {
        try {
            // Log out the admin user using the admin guard
            Auth::guard('admin')->logout();

            // Return a success message upon successful logout
            return ['status' => 200, 'msg' => 'You have been logout successfully.'];
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Initiates the password reset process for the admin user.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public static function Forgot($request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Get input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'email' => 'required|email'
            ]);
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Retrieve the admin user by email
            $adminInfo = Admin::where('email', $input['email'])->first();
            if ($adminInfo == null) {
                return ['status' => 500, 'error' => ['email' => ['Email is not exist. Please re-check your email address.']]];
            }

            // Generate a random reset code and update the admin user's reset_code field
            $reset_code = rand(100000, 999999);
            $adminInfo->reset_code = $reset_code;
            $adminInfo->save();

            // Send a password reset email with the reset code
            Mail::send('emails.forgot', ['userInfo' => $adminInfo], function ($message) use ($adminInfo) {
                $message->to($adminInfo['email'], $adminInfo['name'])->subject(env('MAIL_FROM_NAME') . ': Password Reset Code');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            // Commit the database transaction
            DB::commit();

            // Return a success message upon successful initiation of the password reset process
            return ['status' => 200, 'success' => 'A reset code has been sent to your mail. Please check your email'];
        } catch (\Exception $e) {
            // Roll back the database transaction in case of an exception and return an error response
            DB::rollBack();
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Resets the password for the admin user using the provided reset code.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public static function Reset($request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Get input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'email' => 'required|email',
                'code' => 'required',
                'password' => 'required|confirmed'
            ]);
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Retrieve the admin user by email and reset code
            $adminInfo = Admin::where(['email' => $input['email'], 'reset_code' => $input['code']])->first();
            if ($adminInfo == null) {
                return ['status' => 500, 'error' => ['code' => ['Invalid Request. Please check your reset code please.']]];
            }

            // Check if the new password is the same as the current password
            if (Hash::check($input['password'], $adminInfo['password'])) {
                return ['status' => 500, 'error' => ['password' => ['Repeat password is not allowed. Try another password please']]];
            }

            // Update the admin user's password, reset_code, and save changes
            $adminInfo->password = bcrypt($input['password']);
            $adminInfo->reset_code = null;
            $adminInfo->save();

            // Commit the database transaction
            DB::commit();

            // Return a success message upon successful password reset
            return ['status' => 200, 'success' => 'Password has been reset successfully.'];
        } catch (\Exception $e) {
            // Roll back the database transaction in case of an exception and return an error response
            DB::rollBack();
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Retrieves the profile information of the authenticated admin user.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public static function GetProfile($request)
    {
        try {
            // Get the ID of the authenticated admin user
            $adminId = Auth::guard('admin')->id();

            // Retrieve the admin user's profile information by ID
            $adminProfile = Admin::where('_id', $adminId)->first();

            // Return a success response with the admin user's profile data
            return ['status' => 200, 'data' => $adminProfile];
        } catch (\Exception $e) {
            // Return an error response in case of an exception
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Updates the profile information of the authenticated admin user.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public static function UpdateProfile($request)
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required'
            ]);

            // Check for validation errors
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Get the authenticated admin user by ID
            $admin = Admin::where('_id', Auth::guard('admin')->id())->first();

            // Check if the admin user exists
            if ($admin == null) {
                return ['status' => 500, 'error' => ['error' => ['Invalid Request!']]];
            }

            // Update the admin user's name and email
            $admin->name = $input['name'];
            $admin->email = $input['email'];
            $admin->save();

            // Return a success response
            return ['status' => 200, 'msg' => 'Profile has been updated successfully.'];
        } catch (\Exception $e) {
            // Return an error response in case of an exception
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Changes the password of the authenticated admin user.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public static function ChangePassword($request)
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'current_password' => 'required|min:8',
                'password' => 'required|min:8|confirmed',
            ]);

            // Check for validation errors
            if ($validator->fails()) {
                return ['status' => 400, 'error' => $validator->errors()];
            }

            // Get the authenticated admin user by ID
            $user = Admin::where('_id', Auth::guard('admin')->id())->first();

            // Check if the admin user exists
            if ($user == null) {
                return ['status' => 500, 'error' => ['error' => ['Invalid Request!']]];
            }

            // Check if the current password matches the stored password
            if (!(Hash::check($input['current_password'], $user->password))) {
                return ['status' => 400, 'error' => ['current_password' => ['Please enter correct current password.']]];
            }

            // Check if the new password is different from the previous password
            if ((Hash::check($input['password'], $user->password))) {
                return ['status' => 400, 'error' => ['password' => ['Your new password must be different from your previous password.']]];
            }

            // Update the admin user's password and set the updated_at timestamp
            $user->password = bcrypt($input['password']);
            $user->updated_at = Carbon::now('UTC');
            $user->save();

            // Return a success response
            return ['status' => 200, 'msg' => 'Password has been changed successfully.'];
        } catch (\Exception $e) {
            // Return an error response in case of an exception
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Updates the avatar of the authenticated admin user.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public static function updateAvatar($request)
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'avatar' => 'required'
            ]);

            // Check for validation errors
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Get the authenticated admin user by ID
            $user = Admin::where('_id', Auth::guard('admin')->id())->first();

            // Check if the admin user exists
            if ($user == null) {
                return ['status' => 500, 'error' => ['error' => ['Invalid Request!']]];
            }

            // Update the admin user's avatar
            $user->avatar = $input['avatar'];
            $user->save();

            // Return a success response
            return ['status' => 200, 'msg' => 'Avatar has been changed successfully.'];
        } catch (\Exception $e) {
            // Return an error response in case of an exception
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

}
