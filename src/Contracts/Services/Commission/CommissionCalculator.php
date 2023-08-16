<?php


namespace App\Contracts\Services\Commission;


interface CommissionCalculator
{
    /**
     * @param string $transactionJson
     * @return float
     */
    public function calculateCommission(string $transactionJson): float;
}
