<?php


namespace App\Services\Helpers;


use App\Contracts\Services\Helpers\CountryChecker;

class DefaultCountryChecker implements CountryChecker
{
    const EU_COUNTRIES = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI',
        'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT',
        'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
    ];

    /**
     * @inheritDoc
     */
    public function isEuCountry(string $countryCode): bool
    {
        return in_array($countryCode, self::EU_COUNTRIES);
    }
}
