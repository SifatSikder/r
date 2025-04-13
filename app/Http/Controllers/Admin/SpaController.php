<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class SpaController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * SpaController constructor.
     * Uncomment the following code to enable maintenance mode for specific hosts.
     */
    public function __construct()
    {
        /*
        $host = request()->getHost();
        if (in_array($host, ['mot4ai.com', 'mot4ai.co.uk'])) {
            abort('503');
        }
        */
    }

    /**
     * Display the main SPA (Single Page Application) view for the admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated admin user.
        $Auth = Auth::guard('admin')->user();

        // Return the main SPA view with the authenticated user data.
        return view('admin.app', compact('Auth'));
    }

    /**
     * Display the bot evaluation SPA view.
     *
     * @return \Illuminate\View\View
     */
    public function bot_evaluation()
    {
        return view('Front.pages.risk_evaluation.bots');
    }

    /**
     * Display the risk evaluation SPA view.
     *
     * @return \Illuminate\View\View
     */
    public function risk_evaluation()
    {
        return view('Front.pages.risk_evaluation.risk');
    }

    /**
     * Display the awareness evaluation SPA view.
     *
     * @return \Illuminate\View\View
     */
    public function awareness_evaluation()
    {
        return view('Front.pages.awareness_evaluation.awareness');
    }

    /**
     * Display the portal SPA view.
     *
     * @return \Illuminate\View\View
     */
    public function portal()
    {
        return view('Portal.app');
    }
}
