<?php


namespace App\Services\Providers;


use App\Contracts\Services\Providers\BinProvider;

class DefaultBinProvider implements BinProvider
{

    public function getBinInfo(string $bin): array
    {
        /**
         * TODO: Implement getBinInfo() method.
         * Implement logic to fetch and return bin information from API.
         * For example: Make an API call to https://lookup.binlist.net/$bin
         *
        */

        return [
            'country' => [
                'alpha2' => 'DE'
            ]
        ];
    }
}
