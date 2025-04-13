<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * SpaController constructor.
     * Uncomment the following code to enable maintenance mode for specific hosts.
     */
    public function __construct()
    {
        /*
        // Get the current host from the request.
        $host = request()->getHost();

        // Check if the host is in the specified list.
        if (in_array($host, ['mot4ai.com', 'mot4ai.co.uk'])) {
            // If the host is in the list, abort the request with a 503 Service Unavailable error.
            abort('503');
        }
        */
    }

    /**
     * Attempt to authenticate and log in the user.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     */
    public function Login(Request $request)
    {
        try {
            $input = $request->input();

            // Validate input data
            $validator = Validator::make($input, [
                'email' => 'required|exists:users,email',
                'password' => 'required|min:6',
                'g-recaptcha-response' => 'required',
            ]);

            // Redirect back with errors if validation fails
            if ($validator->fails()) {
                return redirect()->back()->withInput($input)->withErrors($validator->errors());
            }

            // The function would typically interact with the reCAPTCHA API to verify the user's response
            $recaptcha = Helpers::verifyRecaptcha($input['g-recaptcha-response']);
            // Check if the reCAPTCHA verification was successful
            if (isset($recaptcha['success']) && $recaptcha['success'] == true) {
                // Proceed with the form submission or further processing because reCAPTCHA verification passed
                // You might want to include additional logic here based on your application's requirements
            } else {
                // If reCAPTCHA verification failed, redirect back with errors
                return redirect()->back()->withInput($input)->withErrors(['error', ['Recaptcha Test Failed! Try Again.']]);
            }

            // Find user by email
            $user = User::where('email', $input['email'])->first();
            $remember = isset($input['remember']) ? true : false;

            // Check provided password with the found user's hashed password
            if (Hash::check($input['password'], $user->password)) {
                $credential = [
                    'email' => $input['email'],
                    'password' => $input['password']
                ];

                // Attempt to make user logged in
                if (Auth::attempt($credential, $remember)) {
                    // Check for guest user
                    if (isset($input['mot4ai_guest_id']) && !empty($input['mot4ai_guest_id'])) {
                        Evaluation::where('guest_id', $input['mot4ai_guest_id'])
                            ->whereNotNull('guest_id')
                            ->update(['user_id' => Auth::id()]);
                    }

                    // Check for any subscription existence
                    if (!isset($user->subscription_type) || empty($user->subscription_type)) {
                        $user->stripe_customer = null;
                        $user->subscription = null;
                        $user->subscription_type = 'free';
                        $user->save();
                    } elseif ($user->subscription != null) {
                        $user->subscription_type = 'premium';
                        $user->save();
                    }

                    // Redirect to the portal after successful login
                    return redirect()->route('front.portal');
                } else {
                    return redirect()->back()->withInput($input)->withErrors(['email' => ['Invalid credentials! Please try again.']]);
                }
            } else {
                return redirect()->back()->withInput($input)->withErrors(['email' => ['Invalid credentials! Please try again.']]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * User login API
     */
    public function LoginApi(Request $request)
    {
        try {

            $input = $request->input();
            $validator = Validator::make($input, [
                'email' => 'required|exists:users,email',
                'password' => 'required|min:6',
                'g-recaptcha-response' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()]);
            }

            // The function would typically interact with the reCAPTCHA API to verify the user's response
            $recaptcha = Helpers::verifyRecaptcha($input['g-recaptcha-response']);
            // Check if the reCAPTCHA verification was successful
            if (isset($recaptcha['success']) && $recaptcha['success'] == true) {
                // Proceed with the form submission or further processing because reCAPTCHA verification passed
                // You might want to include additional logic here based on your application's requirements
            } else {
                // If reCAPTCHA verification failed, redirect back with errors
                return response()->json(['status' => 500, 'error' => ['email' => ['Recaptcha Test Failed! Try Again.']]]);
            }

            // Find user by email
            $user = User::where('email', $input['email'])->first();
            $remember = isset($input['remember']) ? true : false;

            // Check provided password with the found user's password being hashed
            if (Hash::check($input['password'], $user->password)) {
                $credential = [
                    'email' => $input['email'],
                    'password' => $input['password']
                ];

                // Attempt to make user logged-in
                if (Auth::attempt($credential, $remember)) {

                    // Check for guest user
                    if (isset($input['mot4ai_guest_id']) && !empty($input['mot4ai_guest_id'])) {
                        Evaluation::where('guest_id', $input['mot4ai_guest_id'])->whereNotNull('guest_id')->update(['user_id' => Auth::id()]);
                    }

                    // Check for any subscription existence
                    if (!isset($user->subscription_type) || empty($user->subscription_type)) {
                        $user->stripe_customer = null;
                        $user->subscription = null;
                        $user->subscription_type = 'free';
                        $user->save();
                    } elseif ($user->subscription != null) {
                        $user->subscription_type = 'premium';
                        $user->save();
                    }

                    return response()->json(['status' => 200, 'msg' => 'Login Successful!']);
                } else {
                    return response()->json(['status' => 500, 'error' => ['email' => ['Invalid Credential! Please try again.']]]);
                }
            } else {
                return response()->json(['status' => 500, 'error' => ['email' => ['Invalid Credential! Please try again.']]]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'error' => $e->errors()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Process the forgot password request.
     *
     *  Validates the provided email, generates a password reset link, sends it via email,
     *  and redirects the user with success or error messages accordingly.
     */
    public function Forgot(Request $request)
    {

        try {

            $input = $request->input();
            $validator = Validator::make($input, [
                'email' => 'required|exists:users,email'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput($input)->withErrors($validator->errors());
            }

            // Find the user with the provided email
            $user = User::where('email', $input['email'])->first();

            // Check if the user exists
            if ($user != null) {

                // Generate a unique reset code and save it to the user's record
                $reset_code = time() . $user->id;
                $user->reset_code = $reset_code;
                $user->save();

                // Send a password reset link to the user's email
                Mail::send('emails.forgot', ['userInfo' => $user], function ($message) use ($user) {
                    $message->to($user->email, $user->name)->subject(env('MAIL_FROM_NAME') . ': Password Reset Link');
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });
                return redirect()->back()->withErrors(['success' => ['A password reset link has been sent to your email address.']]);

            } else {
                return redirect()->back()->withInput($input)->withErrors(['email' => ['User not found! Please check your email address.']]);
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Reset the user's password using the provided reset code.
     *
     * @param Request $request
     * @param string $reset_code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function Reset(Request $request, $reset_code)
    {
        try {
            $input = $request->input();

            // Validate input data
            $validator = Validator::make($input, [
                'password' => 'required|confirmed|min:6',
            ]);

            // Redirect back with errors if validation fails
            if ($validator->fails()) {
                return redirect()->back()->withInput($input)->withErrors($validator->errors());
            }

            // Find user by reset code
            $user = User::where('reset_code', $reset_code)->first();

            if ($user != null) {
                // Update user's password and reset code
                $user->reset_code = null;
                $user->password = bcrypt($input['password']);
                $user->save();

                // Redirect to login with success message
                return redirect()->route('front.login')->withErrors(['success' => ['Your account password has been reset successfully!']]);
            } else {
                // Redirect back with error if user not found
                return redirect()->back()->withInput($input)->withErrors(['email' => ['User/email not found! Please enter your email address correctly.']]);
            }
        } catch (\Exception $e) {
            // Redirect back with general error message if an exception occurs
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Register a new user.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function Register(Request $request)
    {
        try {
            $input = $request->input();

            // Validate input data
            $validator = Validator::make($input, [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|unique:users,email',
                'password' => 'required|confirmed|min:6',
                'g-recaptcha-response' => 'required',
            ]);

            // Redirect back with errors if validation fails
            if ($validator->fails()) {
                return redirect()->back()->withInput($input)->withErrors($validator->errors());
            }

            // The function would typically interact with the reCAPTCHA API to verify the user's response
            $recaptcha = Helpers::verifyRecaptcha($input['g-recaptcha-response']);
            // Check if the reCAPTCHA verification was successful
            if (isset($recaptcha['success']) && $recaptcha['success'] == true) {
                // Proceed with the form submission or further processing because reCAPTCHA verification passed
                // You might want to include additional logic here based on your application's requirements
            } else {
                // If reCAPTCHA verification failed, redirect back with errors
                return redirect()->back()->withInput($input)->withErrors(['error', ['Recaptcha Test Failed! Try Again.']]);
            }

            // Create a new user
            $user = User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'name' => $input['first_name'] . ' ' . $input['last_name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'phone' => $input['phone'] ?? null,
                'company' => $input['company'] ?? null,
                'website' => $input['website'] ?? null,
                'stripe_customer' => null,
                'subscription' => null,
                'subscription_type' => 'free',
                'activation_code' => null,
                'reset_code' => null,
                'remember_token' => null,
            ]);

            // Log in the newly created user
            Auth::login($user);


            // Check for guest user
            if (isset($input['mot4ai_guest_id']) && !empty($input['mot4ai_guest_id'])) {
                Evaluation::where('guest_id', $input['mot4ai_guest_id'])
                    ->whereNotNull('guest_id')
                    ->update(['user_id' => Auth::id()]);
            }

            // Redirect to the pricing page after successful registration
            return redirect()->route('front.pricing');

        } catch (\Exception $e) {
            // Redirect back with general error message if an exception occurs
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Register a new user via API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function RegisterApi(Request $request)
    {
        try {
            $input = $request->input();

            // Validate input data
            $validator = Validator::make($input, [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'email' => 'required|unique:users,email',
                'password' => 'required|confirmed|min:6',
                'g-recaptcha-response' => 'required',
            ]);

            // Return JSON response with validation errors if they exist
            if ($validator->fails()) {
                return response()->json(['status' => 500, 'error' => $validator->errors()]);
            }

            // The function would typically interact with the reCAPTCHA API to verify the user's response
            $recaptcha = Helpers::verifyRecaptcha($input['g-recaptcha-response']);
            // Check if the reCAPTCHA verification was successful
            if (isset($recaptcha['success']) && $recaptcha['success'] == true) {
                // Proceed with the form submission or further processing because reCAPTCHA verification passed
                // You might want to include additional logic here based on your application's requirements
            } else {
                // If reCAPTCHA verification failed, redirect back with errors
                return response()->json(['status' => 500, 'error' => ['email' => ['Recaptcha Test Failed! Try Again.']]]);
            }

            // Create a new user
            $user = User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'name' => $input['first_name'] . ' ' . $input['last_name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'phone' => $input['phone'] ?? null,
                'company' => $input['company'] ?? null,
                'website' => $input['website'] ?? null,
                'stripe_customer' => null,
                'subscription' => null,
                'subscription_type' => 'free',
                'activation_code' => null,
                'reset_code' => null,
                'remember_token' => null,
            ]);

            // Log in the newly created user
            Auth::login($user);

            // Uncomment and adapt the following block if Evaluation functionality is needed for API registration
            // if (isset($input['mot4ai_guest_id']) && !empty($input['mot4ai_guest_id'])) {
            //     Evaluation::where('guest_id', $input['mot4ai_guest_id'])
            //         ->whereNotNull('guest_id')
            //         ->update(['user_id' => Auth::id()]);
            // }

            // Return JSON response for successful registration
            return response()->json(['status' => 200, 'msg' => 'Register Successful!']);

        } catch (\Exception $e) {
            // Return JSON response with error details if an exception occurs
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Log out the currently authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Logout(Request $request)
    {
        try {
            // Log out the currently authenticated user
            Auth::logout();

            // Redirect back to the previous page
            return redirect()->back();

        } catch (\Exception $e) {
            // Redirect back with error details if an exception occurs
            return redirect()->back()->withErrors($e->getMessage());
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Process the contact us form submission.
     *
     *  Validates the form input, sends an email notification with the user's message,
     *  and redirects the user with success or error messages accordingly.
     */
    public function contact_us_action(Request $request)
    {
        try {
            $input = $request->input();
            $validator = Validator::make($input, [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'subject' => 'required|min:3',
                'message' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect('/contact-us')->withInput($input)->withErrors($validator->errors());
            }

            // Send an email with the user's message
            Mail::send('emails.contact', ['input' => $input], function ($message) use ($input) {
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->subject(env('MAIL_FROM_NAME') . ': ' . $input['subject']);
            });
            return redirect('/contact-us')->withErrors(['success' => ['Your message has been received! We will contact you soon.']]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
