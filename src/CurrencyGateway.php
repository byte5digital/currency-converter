<?php

namespace Byte5\CurrencyConverter;

use Illuminate\Support\Facades\Cache;
use Byte5\CurrencyConverter\Contracts\HttpClient;

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
     * @var
     */
    protected $url;

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

        if (Cache::has($url))
            return false;

        return $this->client->get($url);
    }

    /**
     * @param $date
     * @return mixed
     */
    public function historicalRates($date)
    {
        return $this->client->get(
            $this->buildUrl('/'.$date)
        );
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
            return $this->url = $url;

        return $this->url = $url.'&symbols='.$this->currencyCodes;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
}