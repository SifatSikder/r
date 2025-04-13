<?php

namespace App\Http\Controllers;

use App\Models\Awareness;
use App\Models\Blog;
use App\Models\CertificateSettings;
use App\Models\RiskFactors;
use App\Models\RiskMatrix;
use App\Models\User;
use App\Models\WorkshopCertificates;
use App\Models\Workshops;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function MongoDB\BSON\toJSON;

class FrontController extends BaseController
{
    public function __construct()
    {
        /*
        |--------------------------------------------------------------------------
        | Constructor
        |--------------------------------------------------------------------------
        |
        | This constructor contains logic to check the host and abort the request
        | with a 503 status if it doesn't match the specified list of allowed hosts.
        |
        | Note: The code is currently commented out and needs to be uncommented
        | if you want to enable this functionality.
        |
        */

        /*
        // Uncomment the following lines to enable host check
        $host = request()->getHost();
        if (in_array($host, ['mot4ai.com', 'mot4ai.co.uk'])) {
            abort(503);
        }
        */
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * Display the home page.
     *
     * retrieves published blog posts, strips HTML tags from their content,
     *  trims the content to a maximum of 150 characters, and passes the processed blog
     *  data to the home page view.
     */
    public function home()
    {
        $blog = Blog::where('status', 'published')->get();

        // Process each blog post's content
        foreach ($blog as &$b) {
            // Strip HTML tags from the content
            $b->content = strip_tags($b->content);
            // Trim the content to a maximum of 150 characters
            $b->content = trim($b->content);
            $b->content = substr($b->content, 0, 150);
        }
        return view('Front.pages.home', ['blog' => $blog]);
    }

    /**
     * Display the view for AI safety risks.
     *
     * @return \Illuminate\View\View
     */
    public function ai_safety_Risks()
    {
        return view('Front.pages.ai_safety_risks');
    }

    /**
     * Display the view for managing AI risk.
     *
     * @return \Illuminate\View\View
     */
    public function manage_ai_risk()
    {
        return view('Front.pages.manage_ai_risk');
    }

    /**
     * Display the view for fair decision analysis.
     *
     * @return \Illuminate\View\View
     */
    public function fair_decision_analysis()
    {
        return view('Front.pages.fair_decision_analysis');
    }

    /**
     * Display the view for training.
     *
     * @return \Illuminate\View\View
     */
    public function training()
    {
        return view('Front.pages.training');
    }


    /**
     * Display the view for awareness.
     *
     * @return \Illuminate\View\View
     */
    public function awareness()
    {
        $courses = Awareness::get()->toArray();
        return view('Front.pages.awareness', compact('courses'));
    }

    /**
     * Display the view for certification.
     *
     * @return \Illuminate\View\View
     */
    public function certification()
    {
        return view('Front.pages.certification');
    }

    /**
     * Display the view for certification workshops.
     *
     * @return \Illuminate\View\View
     */
    public function certification_workshops()
    {
        return view('Front.pages.certification_workshops');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Handle the download and email sending of workshop certificates.
     *
     *  Validates the input data, checks if the workshop code is valid,
     *  ensures that the certificate has not been sent before, generates a PDF certificate,
     *  saves it, sends an email with the certificate, and returns appropriate responses.
     */
    public function certification_workshops_download(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'full_name' => 'required|min:5',
            'email' => 'required|email',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($input)->withErrors($validator->errors());
        }

        // Check if the workshop code is valid
        $workshop = Workshops::where('code', $input['code'])->first();
        if ($workshop == null) {
            return redirect()->back()->withInput($input)->withErrors(['code' => ["Invalid Workshop Code! No Certificate Found."]]);
        }

        // Check if the certificate has already been sent
        $certificate = WorkshopCertificates::where('email', $input['email'])->where('workshop', $workshop->uid)->first();
        if ($certificate != null) {
            return redirect()->back()->withInput($input)->withErrors(['file' => [$certificate->file_path], 'warning' => ["Your certificate has already been sent to your email."]]);
        }

        // Prepare data for the PDF certificate
        $workshop = $workshop->toArray();
        $workshop['user'] = $input;
        $cert_settings = CertificateSettings::where('type', 'workshop')->first();
        if($cert_settings != null){
            $cert_settings = $cert_settings->toArray();
            $cert_settings['description_letter'] = str_replace('[--Evaluation--]', '<strong>'.$workshop['title'].'</strong>', $cert_settings['description_letter']);
            $cert_settings['description_letter'] = str_replace('[--Date--]', '<strong>'.date('d M, Y', strtotime($workshop['title'])).'</strong>', $cert_settings['description_letter']);
        }

        // Create the 'certificate' directory if it doesn't exist
        if (!file_exists(public_path('storage/media/certificate'))) {
            mkdir(public_path('storage/media/certificate'), 0777);
        }

        // Generate the PDF certificate
        $pdf = Pdf::loadView('pdf.certificate_participation', ['workshop' => $workshop, 'cert_settings' => $cert_settings]);
        $pdf->setPaper('a4', 'portrait');
        $pdfName = 'Certificate_of_Participation_'.time().'.pdf';
        $pdfPath = public_path('storage/media/certificate/'.$pdfName);
        $pdfFilePath = asset('storage/media/certificate/'.$pdfName);
        $pdf->save($pdfPath);

        // Save certificate information to the database
        WorkshopCertificates::create([
            'workshop' => $workshop['_id'],
            'full_name' => $input['full_name'],
            'email' => $input['email'],
            'file_path' => $pdfName
        ]);

        // Send email with the certificate as an attachment
        Mail::send('emails.certificate', ['workshop' => $workshop], function ($message) use ($workshop, $pdfPath) {
            $message->to($workshop['user']['email'], $workshop['user']['full_name'])->subject(env('MAIL_FROM_NAME') . ': Certificate of Participation');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $message->attach($pdfPath);
        });

        return redirect()->back()->withErrors(['file' => [$pdfFilePath],'success' => ["Your certificate has been sent to your email."]]);
    }

    /**
     * Display the view for the team page.
     *
     * @return \Illuminate\View\View
     */
    public function team()
    {
        return view('Front.pages.team');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * Display the blog page.
     *
     * retrieves published blog posts, strips HTML tags from their content,
     *  trims the content to a maximum of 150 characters, and passes the processed blog
     *  data to the home page view.
     */
    public function blog_home()
    {
        $blog = Blog::where(['status' => 'published'])->get();
        // Process each blog post's content
        foreach ($blog as &$b) {
            // Strip HTML tags from the content
            $b->content = strip_tags($b->content);
            // Trim the content to a maximum of 150 characters
            $b->content = trim($b->content);
            $b->content = substr($b->content, 0, 150);
        }
        return view('Front.pages.blog-home', [
            'blog' => $blog
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * Display a single Blog
     */
    public function blog($id)
    {
        // Find the blog by id
        $blog = Blog::where('_id', $id)->first();
        return view('Front.pages.blog', [
            'blog' => $blog
        ]);
    }

    /**
     * Display the pricing page with user-specific information.
     *
     * @return \Illuminate\View\View
     */
    public function pricing()
    {
        // Retrieve the current authenticated user
        $user = User::where('_id', Auth::id())->first();

        // Pass the user information to the pricing view
        return view('Front.pages.pricing', compact('user'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Stripe\Exception\ApiErrorException
     *
     * Handle successful subscription confirmation.
     *
     *  Retrieves information about the completed Stripe checkout session,
     *  updates the user's Stripe-related data in the database, and redirects to the
     *  pricing page.
     */
    public function subscribe_success(Request $request)
    {
        // Initialize the Stripe client with the secret key
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        // Retrieve the checkout session details using the session ID from the query parameters
        $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);

        // Retrieve customer details associated with the session
        $customer = $stripe->customers->retrieve($session->customer);
        $customer = json_decode($customer->toJSON(), true);

        // Retrieve subscription details associated with the session
        $subscription = $stripe->subscriptions->retrieve($session->subscription);
        $subscription = json_decode($subscription->toJSON(), true);

        // Find the user in the database using the authenticated user's ID
        $user = User::where('_id', Auth::id())->first();

        // Update user's Stripe-related data in the database
        $user->stripe_customer = $customer;
        $user->subscription = $subscription;
        $user->subscription_type = 'premium';
        $user->save();

        // Redirect to the pricing page
        return redirect()->route('front.pricing');
    }

    public function subscribe_error(Request $request)
    {
        return $request->all();
    }

    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     * @throws \Stripe\Exception\ApiErrorException
     *
     *  Manage user subscriptions based on the specified type.
     *
     *  Handles subscription-related actions such as canceling, upgrading to premium,
     *  or switching to a free subscription. It interacts with the Stripe API to perform these actions
     *  and updates the user's subscription information in the database accordingly.
     */
    public function subscribe_make(Request $request, $type)
    {
        // Check if the specified type is 'cancel'
        if ($type == 'cancel') {
            // Retrieve the user from the database using the authenticated user's ID
            $user = User::where('_id', Auth::id())->first();

            // Check if the user has an active subscription
            if ($user->subscription !== null) {
                // Initialize the Stripe client with the secret key
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

                // Cancel the user's subscription using the Stripe API
                $subscription = $stripe->subscriptions->cancel($user->subscription['id']);
                $subscription = json_decode($subscription->toJSON(), true);

                // Update user's subscription information in the database
                $user->subscription = $subscription;
                $user->subscription_type = 'free';
                $user->save();
            }

            // Redirect to the pricing page
            return redirect()->route('front.pricing');
        } elseif ($type == 'premium') {
            // Handle the 'premium' subscription type

            // Retrieve the user from the database using the authenticated user's ID
            $user = User::where('_id', Auth::id())->first();

            // Check if the user already has an active premium subscription
            if ($user->subscription != null && $user->subscription['status'] == 'active') {
                // Redirect to the pricing page if the user already has an active subscription
                return redirect()->route('front.pricing');
            }

            // Initialize the Stripe client with the secret key
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

            // Create a new checkout session for the premium subscription
            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => [[
                    'price' => env('STRIPE_PREMIUM_PRICE'),
                    'quantity' => 1,
                ]],
                'allow_promotion_codes' => true,
                'mode' => 'subscription',
                'success_url' => route('front.subscribe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('front.pricing')
            ]);

            // Redirect the user to the checkout session URL
            return redirect($checkout_session->url);
        } elseif ($type == 'free') {
            // Handle the 'free' subscription type

            // Retrieve the user from the database using the authenticated user's ID
            $user = User::where('_id', Auth::id())->first();

            // Check if the user already has an active subscription
            if ($user->subscription != null && $user->subscription['status'] == 'active') {
                // Redirect to the pricing page if the user already has an active subscription
                return redirect()->route('front.pricing');
            } else {
                // Update user's information for a free subscription
                $user->stripe_customer = null;
                $user->subscription = null;
                $user->subscription_type = 'free';
                $user->save();

                // Redirect to the pricing page
                return redirect()->route('front.pricing');
            }
        }
    }

    /**
     * Display the privacy policy page.
     *
     * @return \Illuminate\View\View
     */
    public function privacy_policy()
    {
        return view('Front.pages.privacy_policy');
    }

    /**
     * Display the contact us page.
     *
     * @return \Illuminate\View\View
     */
    public function contact_us()
    {
        return view('Front.pages.contact_us');
    }

    /**
     * Display the cookie policy page.
     *
     * @return \Illuminate\View\View
     */
    public function cookie_policy()
    {
        return view('Front.pages.cookie_policy');
    }

    /**
     * Display the terms and conditions page.
     *
     * @return \Illuminate\View\View
     */
    public function terms_conditions()
    {
        return view('Front.pages.terms_conditions');
    }

    /**
     * Display the login page.
     *
     * @return \Illuminate\View\View
     */
    public function Login()
    {
        return view('Front.pages.auth.login');
    }

    /**
     * Display the registration page.
     *
     * @return \Illuminate\View\View
     */
    public function Register()
    {
        return view('Front.pages.auth.register');
    }

    /**
     * Display the forgot password page.
     *
     * @return \Illuminate\View\View
     */
    public function Forgot()
    {
        return view('Front.pages.auth.forgot');
    }

    /**
     * Display the password reset page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $reset_code
     * @return \Illuminate\View\View
     */
    public function Reset(Request $request, $reset_code)
    {
        // Check if the reset code is valid
        $reset_check = User::where('reset_code', $reset_code)->first();
        if ($reset_check == null) {
            abort('404');
        }

        // Display the password reset page with the reset code
        return view('Front.pages.auth.reset', compact('reset_code'));
    }

}
