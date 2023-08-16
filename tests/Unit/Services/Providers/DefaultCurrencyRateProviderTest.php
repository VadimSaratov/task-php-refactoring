<?php

namespace Tests\Unit\Services\Providers;

use App\Services\Providers\DefaultCurrencyRateProvider;
use PHPUnit\Framework\TestCase;

class DefaultCurrencyRateProviderTest extends TestCase
{
    /**
     * @var DefaultCurrencyRateProvider
     */
    private DefaultCurrencyRateProvider $testObject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testObject = new DefaultCurrencyRateProvider();
    }

    public function testGetBinInfo()
    {
        //TODO: update unit test when implementing API call
        $this->assertSame(1.00, $this->testObject->getExchangeRate("EUR"));
    }
}
