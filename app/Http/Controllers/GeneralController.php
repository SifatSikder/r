<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\TrainingAttendees;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GeneralController extends BaseController
{

    public function __construct()
    {
        /*$host = request()->getHost();
        if (in_array($host, ['mot4ai.com', 'mot4ai.co.uk'])) {
            abort('503');
        }*/
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Process the request to register training attendees.
     *
     *  Validates the provided attendee information, creates a new record in the TrainingAttendees model,
     *  and redirects the user with success or error messages accordingly.
     */
    public function training_attendees(Request $request)
    {
        try {
            $input = $request->input();
            $validator = Validator::make($input, [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput($input)->withErrors($validator->errors());
            }

            // Create a new record in the TrainingAttendees model
            TrainingAttendees::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
            ]);
            return redirect()->back()->withErrors(['success' => 1]);

        } catch (\Exception $e) {
            // Handle exceptions and redirect back with an error message
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
