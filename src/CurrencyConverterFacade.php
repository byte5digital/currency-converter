<?php

namespace Byte5\CurrencyConverter;

use Illuminate\Support\Facades\Facade;

class CurrencyConverterFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'currency';
    }
}