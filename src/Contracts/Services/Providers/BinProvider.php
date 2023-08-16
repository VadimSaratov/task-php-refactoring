<?php


namespace App\Contracts\Services\Providers;


interface BinProvider
{
    /**
     * @param string $bin
     * @return array|null
     */
    public function getBinInfo(string $bin): ?array;
}