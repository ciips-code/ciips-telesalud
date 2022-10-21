<?php

namespace App\Providers;

use App\Interfaces\JitsiService;
use App\Services\JitsiJitsiService;
use App\Services\JitsiSelfHostedService;
use Illuminate\Support\ServiceProvider;

class JitsiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(JitsiService::class, function ($app) {

            switch (config('services.jitsi.provider')) {
                case 'self':
                    return new JitsiSelfHostedService();
                case 'jitsi':
                    return new JitsiJitsiService();

            }
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
