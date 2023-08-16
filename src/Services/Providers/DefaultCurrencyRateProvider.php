<?php


namespace App\Services\Providers;


use App\Contracts\Services\Providers\CurrencyRatesProvider;

class DefaultCurrencyRateProvider implements CurrencyRatesProvider
{
    /**
     * @inheritDoc
     */
    public function getExchangeRate(string $currency): float
    {
        /**
         * TODO: Implement getExchangeRate() method.
         * Implement logic to fetch exchange rate for the given currency from the API
         * for example make an API call to https://api.exchangeratesapi.io/latest
         */

        return 1.00;
    }
}
