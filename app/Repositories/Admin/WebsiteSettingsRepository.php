<?php

namespace App\Repositories\Admin;

use App\Models\WebsiteSettings;
use Illuminate\Support\Facades\Validator;

class WebsiteSettingsRepository
{
    /**
     * Stores website settings based on the provided input.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function StoreSettings($request)
    {
        try {
            // Retrieve input data from the request
            $input = $request->input();

            // Validate the input data
            $validator = Validator::make($input, [
                'settings' => 'required'
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return ['status' => 500, 'error' => $validator->errors()];
            }

            // Update or create each type of website setting based on input
            if (isset($input['settings']['meta_info'])) {
                self::updateOrCreateSetting('meta_info', $input['settings']['meta_info']);
            } elseif (isset($input['settings']['homepage'])) {
                self::updateOrCreateSetting('homepage', $input['settings']['homepage']);
            } elseif (isset($input['settings']['safety'])) {
                self::updateOrCreateSetting('safety', $input['settings']['safety']);
            } elseif (isset($input['settings']['evaluation'])) {
                self::updateOrCreateSetting('evaluation', $input['settings']['evaluation']);
            } elseif (isset($input['settings']['fair_decision'])) {
                self::updateOrCreateSetting('fair_decision', $input['settings']['fair_decision']);
            } elseif (isset($input['settings']['training'])) {
                self::updateOrCreateSetting('training', $input['settings']['training']);
            } elseif (isset($input['settings']['awareness'])) {
                self::updateOrCreateSetting('awareness', $input['settings']['awareness']);
            } elseif (isset($input['settings']['certification'])) {
                self::updateOrCreateSetting('certification', $input['settings']['certification']);
            } elseif (isset($input['settings']['team'])) {
                self::updateOrCreateSetting('team', $input['settings']['team']);
            } elseif (isset($input['settings']['contact'])) {
                self::updateOrCreateSetting('contact', $input['settings']['contact']);
            } elseif (isset($input['settings']['social'])) {
                self::updateOrCreateSetting('social', $input['settings']['social']);
            } elseif (isset($input['settings']['privacy_policy'])) {
                self::updateOrCreateSetting('privacy_policy', $input['settings']['privacy_policy']);
            } elseif (isset($input['settings']['cookie_policy'])) {
                self::updateOrCreateSetting('cookie_policy', $input['settings']['cookie_policy']);
            } elseif (isset($input['settings']['terms_conditions'])) {
                self::updateOrCreateSetting('terms_conditions', $input['settings']['terms_conditions']);
            }

            // Return success response
            return ['status' => 200, 'msg' => 'Website settings have been updated successfully.'];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    /**
     * Updates or creates a specific website setting based on type and input data.
     *
     * @param string $type
     * @param array $settings
     */
    private static function updateOrCreateSetting($type, $settings)
    {
        $websiteSetting = WebsiteSettings::where('type', $type)->first();

        if ($websiteSetting == null) {
            WebsiteSettings::create([
                'type' => $type,
                'settings' => $settings
            ]);
        } else {
            $websiteSetting->settings = $settings;
            $websiteSetting->save();
        }
    }

    /**
     * Retrieves website settings of a specific type.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $type
     * @return array
     */
    public static function GetSettings($request, $type)
    {
        try {
            // Fetch website settings based on the provided type
            $websiteSettings = WebsiteSettings::where('type', $type)->first();

            // Return success response with data
            return ['status' => 200, 'data' => $websiteSettings];

        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

}
