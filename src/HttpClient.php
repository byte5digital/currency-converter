<?php

namespace Naoray\CurrencyConverter;

use Zttp\Zttp;
use \Naoray\CurrencyConverter\Contracts\HttpClient as HttpClientContract;

class HttpClient implements HttpClientContract
{
    /**
     * @var Zttp
     */
    protected $client;

    /**
     * HttpClient constructor.
     */
    public function __construct()
    {
        $this->client = Zttp::new();
    }

    /**
     * @param $url
     * @param array $queryParams
     * @return mixed
     */
    public function get($url, $queryParams = [])
    {
        return $this->client->get($url, $queryParams);
    }
}