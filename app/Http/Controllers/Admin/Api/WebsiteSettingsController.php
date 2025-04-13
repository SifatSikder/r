<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\WebsiteSettingsRepository;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    /**
     * Get website settings based on the specified type.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetSettings(Request $request, $type)
    {
        // Call the GetSettings method from WebsiteSettingsRepository to retrieve website settings for the specified type.
        $rv = WebsiteSettingsRepository::GetSettings($request, $type);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }

    /**
     * Store website settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function StoreSettings(Request $request)
    {
        // Call the StoreSettings method from WebsiteSettingsRepository to store/update website settings.
        $rv = WebsiteSettingsRepository::StoreSettings($request);

        // Return the response as JSON with a status code of 200.
        return response()->json($rv, 200);
    }
}
