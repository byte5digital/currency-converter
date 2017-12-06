<?php

namespace Naoray\CurrencyConverter;

use Illuminate\Support\Facades\Cache;
use Naoray\CurrencyConverter\Contracts\HttpClient;

class CurrencyGateway
{
    /**
     * @var string
     */
    protected $apiURI = 'https://api.fixer.io';

    /**
     * @var string
     */
    protected $base = 'EUR';

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var
     */
    protected $currencyCodes;

    /**
     * CurrencyGateway constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function latestRates()
    {
        $url = $this->buildUrl('/latest');

        return $this->execute($url);
    }

    /**
     * @param $date
     * @return mixed
     */
    public function historicalRates($date)
    {
        $url = $this->buildUrl('/'.$date);

        return $this->execute($url);
    }

    /**
     * @param $currencyCode
     */
    public function setBase($currencyCode)
    {
        $this->base = $currencyCode;
    }

    /**
     * @param $currencyCodes
     */
    public function setCurrencyCodes($currencyCodes)
    {
        if (is_array($currencyCodes)) {
            $currencyCodes = implode(',', $currencyCodes);
        }

        $this->currencyCodes = $currencyCodes;
    }

    /**
     * @param $urlPath
     * @return string
     * @internal param $currencyCodes
     */
    private function buildUrl($urlPath)
    {
        $url = $this->apiURI.$urlPath.'?base='.$this->base;

        if (! $this->currencyCodes)
            return $url;

        return $url.'&symbols='.$this->currencyCodes;
    }

    /**
     * @param $url
     * @return mixed
     */
    private function execute($url)
    {
        return Cache::remember($url, config('currency.cache_duration'), function () use ($url) {
            return $this->client->get($url);
        });
    }
}