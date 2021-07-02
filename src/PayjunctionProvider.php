<?php

namespace Jsdecena\Payjunction;

use Illuminate\Support\ServiceProvider;

class PayjunctionProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');

        $this->publishes([
            __DIR__ . '/config/payjunction.php' => config_path('payjunction.php'),
        ]);
    }

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        //
    }
}
