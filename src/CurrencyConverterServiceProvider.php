<?php

namespace Naoray\CurrencyConverter;

use Illuminate\Support\ServiceProvider;
use \Naoray\CurrencyConverter\Contracts\HttpClient as HttpClientContract;

class CurrencyConverterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/currency.php' => config_path('currency.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/currency.php', 'currency');

        $this->app->bind(HttpClientContract::class, HttpClient::class);

        $this->app->bind('CurrencyGateway', CurrencyGateway::class);

        $this->app->bind('currency', CurrencyManager::class);
    }
}
