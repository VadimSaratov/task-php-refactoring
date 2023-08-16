<?php


namespace App\Contracts\Services\Helpers;


interface CountryChecker
{
    /**
     * @param string $countryCode
     * @return bool
     */
    public function isEuCountry(string $countryCode): bool;
}