<?php
require 'vendor/autoload.php';

use App\Services\Commission\DefaultCommissionCalculator;
use App\Services\Helpers\DefaultCountryChecker;
use App\Services\Providers\DefaultBinProvider;
use App\Services\Providers\DefaultCurrencyRateProvider;
use GuzzleHttp\Client;

$httpClient = new Client();
$binProvider = new DefaultBinProvider($httpClient);
$currencyRatesProvider = new DefaultCurrencyRateProvider();
$countryChecker = new DefaultCountryChecker();

$calculator = new DefaultCommissionCalculator($binProvider, $currencyRatesProvider, $countryChecker);

foreach (explode("\n", file_get_contents($argv[1])) as $row) {
    if (empty($row)) break;
    echo $calculator->calculateCommission($row) . "\n";
}