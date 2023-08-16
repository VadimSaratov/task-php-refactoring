<?php


namespace App\Services\Helpers;


use App\Contracts\Services\Helpers\CountryChecker;

class DefaultCountryChecker implements CountryChecker
{

    public function isEuCountry(string $countryCode): bool
    {
        // TODO: Implement isEuCountry() method.
    }
}
