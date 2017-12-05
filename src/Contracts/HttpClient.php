<?php

namespace Naoray\CurrencyConverter\Contracts;

interface HttpClient
{
    public function get($url, $queryParams = []);
}