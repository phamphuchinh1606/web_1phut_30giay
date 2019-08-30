<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //Build data app info
        View::composer(['admin.*'],
            'App\Http\ViewComposers\AppInfoComposer');

        View::composer(['employee.*'],
            'App\Http\ViewComposers\AppInfoEmployeeComposer');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}
