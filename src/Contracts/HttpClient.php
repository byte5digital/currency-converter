<?php

namespace Byte5\CurrencyConverter\Contracts;

interface HttpClient
{
    public function get($url, $queryParams = []);
}