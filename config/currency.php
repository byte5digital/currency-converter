<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Currency Caching Duration
     |--------------------------------------------------------------------------
     |
     | Determines how long a request is cached through the Cache facade.
     | Default caching duration is set to 24 h.
     |
     */
    'cache_duration' => 60 * 24,

    /*
     |--------------------------------------------------------------------------
     | Fixer Api Key
     |--------------------------------------------------------------------------
     |
     | If you don't have a fixer.io account yet, you need to register
     | and go to https://fixer.io/dashboard to get your api key.
     |
     */

    'api_key' => env('FIXER_API_KEY', ''),

    /*
     |--------------------------------------------------------------------------
     | Fixer Free Plan
     |--------------------------------------------------------------------------
     |
     | Since fixer.io's update there are more features you can use with
     | the fixer.io api, however this package uses this option only
     | to determine if you can use `https` in your api call.
     |
     */

    'use_free_plan' => env('FIXER_USE_FREE_PLAN', true),
];
