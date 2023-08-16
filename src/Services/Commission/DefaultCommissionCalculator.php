<?php


namespace App\Services\Commission;


use App\Contracts\Services\Commission\CommissionCalculator;

class DefaultCommissionCalculator implements CommissionCalculator
{
    public function calculateCommission(string $transactionJson): float
    {
        // TODO: Implement calculateCommission() method.
    }
}