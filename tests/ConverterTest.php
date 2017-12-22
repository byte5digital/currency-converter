<?php

namespace Byte5\CurrencyConverter\Test;

use Carbon\Carbon;
use Byte5\CurrencyConverter\Exceptions\NotAllowedException;

class ConverterTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->currencyManager = app()->make('currency');
    }

    /**
     * Get api date.
     *
     * @return static
     */
    private function getApiDate()
    {
        return Carbon::yesterday()->addHours(16)->diffInHours(Carbon::now()) >= 24
            ? Carbon::today() : Carbon::yesterday();
    }

    /** @test **/
    function it_can_receive_latest_currency_rates()
    {
        $response = $this->currencyManager->getLatestRates();

        $this->assertArraySubset(['base' => 'EUR', 'date' => $this->getApiDate()->toDateString()], $response);
    }
    
    /** @test **/
    function it_can_receive_historical_currency_rates()
    {
        $response  = $this->currencyManager->getHistoricalRates('2000-01-03');

        $this->assertArraySubset(['date' => '2000-01-03'], $response);
    }

    /** @test **/
    function it_can_receive_historical_currency_rates_with_different_base()
    {
        $response = $this->currencyManager->setBase('USD')->getHistoricalRates('2000-01-03');

        $this->assertArrayHasKey('EUR', $response['rates']);
    }

    /** @test **/
    function it_can_receive_historical_currency_rates_for_specific_currencies()
    {
        $response  = $this->currencyManager->getHistoricalRates('2000-01-03', 'USD');

        $this->assertArrayHasKey('USD', $response['rates']);
        $this->assertArrayNotHasKey('GBP', $response['rates']);
    }

    /** @test **/
    function it_can_change_base_currency_for_which_the_rates_are_received()
    {
        $response = $this->currencyManager->setBase('USD')->getLatestRates();

        $this->assertArraySubset(['base' => 'USD', 'date' => $this->getApiDate()->toDateString()], $response);
    }

    /**
     * @test
     * @expectedException NotAllowedException
     */
    function it_throws_an_error_if_base_is_set_to_unallowed_currency()
    {
        $this->expectException(NotAllowedException::class);
        $notAllowedCode = 'not-allowed';

        $this->currencyManager->setBase($notAllowedCode);

        $this->expectExceptionMessage("The currency with code $notAllowedCode is not available for converting.");
    }

    /** @test **/
    function it_can_receive_specific_currency_rates()
    {
        $response = $this->currencyManager->getLatestRates(['USD', 'GBP']);

        $this->assertArrayNotHasKey('ZAR', $response['rates']);
        $this->assertArrayHasKey('USD', $response['rates']);
        $this->assertArrayHasKey('GBP', $response['rates']);
    }

    /** @test **/
    function it_can_convert_currencies()
    {
        $resultA = $this->currencyManager->convert(100, 'EUR', 'USD');
        $resultB = $this->currencyManager->convert(100, 'EUR')->into('USD');

        $expected = $this->currencyManager->getLatestRates('USD')['rates']['USD'] * 100;

        $this->assertEquals($resultA, $resultB);
        $this->assertEquals($expected, $resultA);
    }
}