<?php

namespace Naoray\CurrencyConverter;

use Illuminate\Support\ServiceProvider;

class CurrencyConverterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('CurrencyGateway', function () {
            return new CurrencyGateway(new HttpClient);
        });

        app()->bind('currency', function() {
            return new CurrencyManager(app()->make('CurrencyGateway'));
        });
    }
}
