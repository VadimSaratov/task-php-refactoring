<?php


namespace App\Services\Commission;


use App\Contracts\Services\Commission\CommissionCalculator;
use App\Contracts\Services\Helpers\CountryChecker;
use App\Contracts\Services\Providers\BinProvider;
use App\Contracts\Services\Providers\CurrencyRatesProvider;
use App\Exceptions\Commission\CommissionCalculationException;

class DefaultCommissionCalculator implements CommissionCalculator
{
    const COMMISSION_CURRENCY = 'EUR';
    const EU_COMMISSION_RATE = 0.01;
    const NON_EU_COMMISSION_RATE = 0.02;

    /**
     * @var BinProvider
     */
    private BinProvider $binProvider;
    /**
     * @var CurrencyRatesProvider
     */
    private CurrencyRatesProvider $currencyRatesProvider;
    /**
     * @var CountryChecker
     */
    private CountryChecker $countryChecker;

    /**
     * DefaultCommissionCalculator constructor.
     * @param BinProvider $binProvider
     * @param CurrencyRatesProvider $currencyRatesProvider
     * @param CountryChecker $countryChecker
     */
    public function __construct(
        BinProvider $binProvider,
        CurrencyRatesProvider $currencyRatesProvider,
        CountryChecker $countryChecker
    )
    {
        $this->binProvider = $binProvider;
        $this->currencyRatesProvider = $currencyRatesProvider;
        $this->countryChecker = $countryChecker;
    }

    public function calculateCommission(string $transactionJson): float
    {
        $transaction = json_decode($transactionJson, true);

        if (!isset($transaction['bin'])) {
            throw new CommissionCalculationException('Bin code is missing in the transaction!');
        }

        if (!isset($transaction['currency'])) {
            throw new CommissionCalculationException('Currency code is missing in the transaction!');
        }

        if (!isset($transaction['amount'])) {
            throw new CommissionCalculationException('Amount is missing in the transaction!');
        }

        $binInfo = $this->binProvider->getBinInfo($transaction['bin']);

        if ($binInfo === null || !isset($binInfo['country']['alpha2'])) {
            throw new CommissionCalculationException('Information about bin is missing or the format is invalid!');
        }

        $rate = $this->currencyRatesProvider->getExchangeRate($transaction['currency']);

        $amountFixed = ($transaction['currency'] == self::COMMISSION_CURRENCY || $rate == 0)
            ? $transaction['amount']
            : $transaction['amount'] / $rate;

        $commission = $amountFixed * $this->getCommissionRate($binInfo['country']['alpha2']);

        return ceil($commission * 100) / 100;

    }

    /**
     * @param string $alpha2
     * @return float
     */
    protected function getCommissionRate(string $alpha2): float
    {
        return $this->countryChecker->isEuCountry($alpha2) ? self::EU_COMMISSION_RATE : self::NON_EU_COMMISSION_RATE;
    }
}