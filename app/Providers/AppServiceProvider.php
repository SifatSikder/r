<?php

namespace App\Providers;

use App\Models\WebsiteSettings;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        self::loadViews();
    }

    /**
     * Load views with website settings data.
     *
     * @return void
     */
    private static function loadViews(){
        $website_settings = [];
        $settings = WebsiteSettings::get()->toArray();

        // Enhance settings data with full paths for banner and image.
        foreach ($settings as $setting) {
            if(isset($setting['settings']['banner']) && $setting['settings']['banner'] != null){
                $setting['settings']['banner_full'] = asset('storage/media/image/'.$setting['settings']['banner']);
            }
            if(isset($setting['settings']['image']) && $setting['settings']['image'] != null){
                $setting['settings']['image_full'] = asset('storage/media/image/'.$setting['settings']['image']);
            }
            $website_settings[$setting['type']] = $setting['settings'];
        }

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.home','Front.pages.manage_ai_risk','Front.pages.training','Front.layouts.components.footer'], function ($view) use($website_settings){
            $view->with(['homepage' => $website_settings['homepage']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.home','Front.pages.manage_ai_risk','Front.pages.awareness','Front.layouts.components.footer'], function ($view) use($website_settings){
            $view->with(['homepage' => $website_settings['homepage']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.ai_safety_risks'], function ($view) use($website_settings){
            $view->with(['safety' => $website_settings['safety']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.manage_ai_risk'], function ($view) use($website_settings){
            $view->with(['evaluation' => $website_settings['evaluation']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.fair_decision_analysis'], function ($view) use($website_settings){
            $view->with(['fair_decision' => $website_settings['fair_decision']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.training','Front.pages.pricing'], function ($view) use($website_settings){
            $view->with(['training' => $website_settings['training']]);
        });

          // Compose views with specific website settings data.
          view()->composer(['Front.pages.awareness','Front.pages.pricing'], function ($view) use($website_settings){
            $view->with(['awareness' => $website_settings['awareness']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.certification','Front.pages.certification_workshops'], function ($view) use($website_settings){
            $view->with(['certification' => $website_settings['certification']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.team'], function ($view) use($website_settings){
            $view->with(['team' => $website_settings['team']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.contact_us','Front.layouts.components.contact','Front.layouts.components.footer'], function ($view) use($website_settings){
            $view->with(['contact' => $website_settings['contact']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.layouts.components.footer'], function ($view) use($website_settings){
            $view->with(['social' => $website_settings['social']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.layouts.components.meta'], function ($view) use($website_settings){
            $view->with(['meta_info' => $website_settings['meta_info']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.privacy_policy'], function ($view) use($website_settings){
            $view->with(['privacy_policy' => $website_settings['privacy_policy']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.cookie_policy'], function ($view) use($website_settings){
            $view->with(['cookie_policy' => $website_settings['cookie_policy']]);
        });

        // Compose views with specific website settings data.
        view()->composer(['Front.pages.terms_conditions'], function ($view) use($website_settings){
            $view->with(['terms_conditions' => $website_settings['terms_conditions']]);
        });
    }
}
