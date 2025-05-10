<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PostHog\PostHog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PostHog::init(
            'phc_uD00zXofVepR1xJvSc76woiu2Btwx7WLo1264sa58TA',
            [
                'host' => 'https://us.i.posthog.com'
            ]
        );
    }
}
