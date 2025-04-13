<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{

    /**
     * DashboardController constructor.
     *
     * Constructor method for DashboardController.
     * Uncomment the code block below to enable host-based access control.
     * If the host is 'mot4ai.com' or 'mot4ai.co.uk', it will return a '503 Service Unavailable' response.
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

}
