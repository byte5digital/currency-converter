<?php

namespace Naoray\CurrencyConverter;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Naoray\CurrencyConverter\Exceptions\NotAllowedException;

class CurrencyManager
{
    /**
     * @var array
     */
    protected $allowedCurrencies = [
        "AUD", "BGN", "BRL", "CAD", "CHF", "CNY", "CZK", "DKK", "EUR", "GBP", "HKD", "HRK", "HUF", "IDR","ILS", "INR",
        "JPY", "KRW", "MXN", "MYR","NOK","NZD","PHP","PLN","RON","RUB","SEK","SGD","THB","TRY","USD","ZAR"
    ];

    /**
     * @var
     */
    private $amount;

    /**
     * @var CurrencyGateway
     */
    protected $gateway;

    /**
     * @var
     */
    private $targetCurrency;

    /**
     * CurrencyConverter constructor.
     *
     * @param CurrencyGateway $gateway
     */
    public function __construct(CurrencyGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @param $amount
     * @param $from
     * @param null $into
     * @return $this|mixed
     */
    public function convert($amount, $from, $into = null)
    {
        if (! $this->isAllowedCode($from) || ($into != null && ! $this->isAllowedCode($into))) {
            $this->throwNotAllowedException("$from or $into");
        }

        $this->setBase($from)->setAmount($amount);

        if (! $into) {
            return $this;
        }

        $this->setTargetCurrency($into);

        return $this->calculateExchangeRate();
    }

    /**
     * @param $currencyCode
     * @return mixed
     */
    public function into($currencyCode)
    {
        $this->setTargetCurrency($currencyCode);

        return $this->calculateExchangeRate();
    }

    /**
     * @param array $currencyCodes
     * @return mixed
     */
    public function getLatestRates($currencyCodes = null)
    {
        $this->gateway->setCurrencyCodes($currencyCodes);

        $jsonResult = $this->gateway->latestRates();

        if (method_exists($jsonResult, 'json'))
            $jsonResult = $jsonResult->json();

        $url = $this->gateway->getUrl();

        return Cache::remember($url, config('currency.cache_duration'), function () use ($jsonResult) {
            return $jsonResult;
        });
    }

    /**
     * @param $date
     * @param null $currencyCode
     * @return mixed
     */
    public function getHistoricalRates($date, $currencyCode = null)
    {
        $this->gateway->setCurrencyCodes($currencyCode);

        if ($date instanceof Carbon) {
            $date = $date->toDateString();
        }

        return $this->gateway->historicalRates($date)->json();
    }

    /**
     * @param $amount
     */
    private function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param $currencyCode
     * @return $this
     */
    public function setBase($currencyCode)
    {
        if (! $this->isAllowedCode($currencyCode)) {
            $this->throwNotAllowedException($currencyCode);
        }

        $this->gateway->setBase($currencyCode);

        return $this;
    }

    /**
     * @param $target
     */
    private function setTargetCurrency($target)
    {
        $this->targetCurrency = $target;
    }

    /**
     * @return mixed
     */
    private function calculateExchangeRate()
    {
        $exchangeRate = $this->getLatestRates($this->targetCurrency)['rates'][$this->targetCurrency];

        return $exchangeRate * $this->amount;
    }

    /**
     * @param $currencyCode
     * @return bool
     */
    private function isAllowedCode($currencyCode)
    {
        return in_array($currencyCode, $this->allowedCurrencies);
    }

    /**
     * @param $currencyCode
     */
    private function throwNotAllowedException($currencyCode)
    {
        throw new NotAllowedException("The currency with code $currencyCode is not available for converting.");
    }
}