<?php

namespace App\Contracts\Services\Providers;

interface CurrencyRatesProvider
{
    /**
     * @param string $currency
     * @return float
     */
    public function getExchangeRate(string $currency): float;
}