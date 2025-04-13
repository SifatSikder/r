<?php

namespace App\Repositories\Admin;

use App\Models\Blog;
use App\Models\Evaluation;
use App\Models\QuestionMitigations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRepository
{
    /**
     * Get a list of users based on the provided search keyword.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function list($request): array
    {
        try {
            // Extract keyword from the request or default to null
            $keyword = $request->keyword ?? null;

            // Retrieve users based on the provided keyword
            $data = User::select('*')->where(function ($q) use ($keyword) {
                if (!empty($keyword)) {
                    $q->where('name', 'LIKE', '%' . $keyword . '%');
                }
            })->orderBy('created_at', 'desc')->get();

            // Process each user in the result set
            foreach ($data as &$each) {
                // Set user avatar, generate one if not available
                if (isset($each->avatar) && $each->avatar != null) {
                    $each->avatar = asset('storage/media/image/' . $each->avatar);
                } else {
                    $each_name = trim(str_replace(' ', '+', $each->name));
                    $avatarStream = file_get_contents("https://ui-avatars.com/api/?name=" . $each_name);
                    $avatar = time() . uniqid() . '.png';
                    file_put_contents(public_path('storage/media/image/' . $avatar), $avatarStream);
                    $each->avatar = $avatar;
                    $each->save();
                    $each->avatar = asset('storage/media/image/' . $each->avatar);
                }

                // Check for any subscription existence
                if (!isset($each->subscription_type) || empty($each->subscription_type)) {
                    $each->stripe_customer = null;
                    $each->subscription = null;
                    $each->subscription_type = 'free';
                    $each->save();
                }

                // Add risk evaluation and fair decision counts to each user
                $each['risk_evaluation'] = Evaluation::where('user_id', $each->_id)->whereIn('category', ['et', 'eta', 'nt'])->count();
                $each['fair_decision'] = Evaluation::where('user_id', $each->_id)->whereIn('category', ['fd', 'eta-fd'])->count();
            }

            // Return the processed data with a status code
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }


    /**
     * Create a new user based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function create($request): array
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|unique:users,email',
                'password' => 'required|confirmed|min:6',
            ]);

            // Return validation errors if validation fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Create a new user with the validated data
            $user = User::create([
                'avatar' => $input['avatar'] ?? null,
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'name' => $input['first_name'] . ' ' . $input['last_name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'phone' => $input['phone'] ?? null,
                'company' => $input['company'] ?? null,
                'website' => $input['website'] ?? null,
                'subscription_type' => $input['subscription_type'] ?? null,
                'activation_code' => null,
                'reset_code' => null,
                'remember_token' => null,
            ]);

            // Return success message and status
            return ['status' => 200, 'msg' => 'A new user has been created successfully.'];

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }


    /**
     * Get details of a single user based on the provided user_id.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function single($request): array
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'user_id' => 'required',
            ]);

            // Return validation errors if validation fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Retrieve user details based on the provided user_id
            $data = User::where('_id', $input['user_id'])->first();

            // If user data exists, add the full path to the avatar
            if ($data != null) {
                $data->avatar_full_path = asset('storage/media/image/' . $data->avatar);
            }

            // Return the processed data with a status code
            return ['status' => 200, 'data' => $data];

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }


    /**
     * Update user information based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function update($request): array
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|unique:users,email,' . $request->get('_id') . ',_id',
                'password' => 'nullable|confirmed|min:6',
            ]);

            // Return validation errors if validation fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Update user information in the database
            User::where('_id', $request->get('_id'))->update([
                'avatar' => $input['avatar'] ?? null,
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'name' => $input['first_name'] . ' ' . $input['last_name'],
                'email' => $input['email'],
                'phone' => $input['phone'] ?? null,
                'company' => $input['company'] ?? null,
                'website' => $input['website'] ?? null,
            ]);

            // Retrieve the updated user
            $user = User::where('_id', $input['_id'])->first();

            // Handle subscription type changes
            if ($user->subscription_type == 'free' && isset($input['subscription_type']) && $input['subscription_type'] == 'premium') {
                $user->subscription_type = 'premium';
                $user->save();
            } elseif ($user->subscription_type == 'premium' && $user->subscription == null && isset($input['subscription_type']) && $input['subscription_type'] == 'free') {
                $user->subscription_type = 'free';
                $user->save();
            } elseif (isset($input['subscription_type']) && $input['subscription_type'] == $user->subscription_type) {
                // Skip & Don't update anything
            } else {
                // Return an error if the Stripe subscription cannot be changed here
                return ['status' => 500, 'error' => ['subscription_type' => ['You cannot change a Stripe Subscription from here.']]];
            }

            // Update user password if provided
            if (isset($input['password']) && !empty($input['password'])) {
                $user->password = bcrypt($input['password']);
                $user->save();
            }

            // Return success message and status
            return ['status' => 200, 'msg' => 'User information has been updated successfully.'];

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }


    /**
     * Delete a user and related data based on the provided user_id.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function delete($request): array
    {
        try {
            // Extract input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'user_id' => 'required',
            ]);

            // Return validation errors if validation fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Retrieve the user to be deleted
            $user = User::where('_id', $request->get('user_id'))->first();

            // Delete related data (evaluations and question mitigations) if the user exists
            if ($user != null) {
                Evaluation::where('user_id', $user->_id)->delete();
                QuestionMitigations::where('user_id', $user->_id)->delete();
                User::where('_id', $request->get('user_id'))->delete();
            }

            // Return success message and status
            return ['status' => 200, 'msg' => 'User information has been removed successfully.'];

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

}
