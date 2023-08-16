<?php

namespace Tests\Unit\Services\Commission;

use App\Contracts\Services\Helpers\CountryChecker;
use App\Contracts\Services\Providers\BinProvider;
use App\Contracts\Services\Providers\CurrencyRatesProvider;
use App\Exceptions\Commission\CommissionCalculationException;
use App\Services\Commission\DefaultCommissionCalculator;
use PHPUnit\Framework\TestCase;

class CalculateCommissionTest extends TestCase
{
    /**
     * @var BinProvider|\PHPUnit\Framework\MockObject\MockObject
     */
    private $binProviderMock;
    /**
     * @var CurrencyRatesProvider|\PHPUnit\Framework\MockObject\MockObject
     */
    private $currencyRatesProviderMock;
    /**
     * @var CountryChecker|\PHPUnit\Framework\MockObject\MockObject
     */
    private $countryCheckerMock;
    /**
     * @var DefaultCommissionCalculator
     */
    private DefaultCommissionCalculator $testObject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->binProviderMock = $this->createMock(BinProvider::class);
        $this->currencyRatesProviderMock = $this->createMock(CurrencyRatesProvider::class);
        $this->countryCheckerMock = $this->createMock(CountryChecker::class);

        $this->testObject = new DefaultCommissionCalculator(
            $this->binProviderMock,
            $this->currencyRatesProviderMock,
            $this->countryCheckerMock
        );
    }

    /**
     * @dataProvider inputAndExpectedOutputDataProvider
     * @param $transaction
     * @param $binInfo
     * @param $isEuCountry
     * @param $rate
     * @param $expectedOutput
     */
    public function testCalculateCommission($transaction, $binInfo, $isEuCountry, $rate, $expectedOutput)
    {
        $this->binProviderMock->method('getBinInfo')->willReturn($binInfo);
        $this->currencyRatesProviderMock->method('getExchangeRate')->willReturn($rate);
        $this->countryCheckerMock->method('isEuCountry')->willReturn($isEuCountry);

        $this->assertEquals($expectedOutput, $this->testObject->calculateCommission($transaction));
    }

    /**
     * @return array[]
     */
    public function inputAndExpectedOutputDataProvider(): array
    {
        return [
            [
                '{"bin":"45717360","amount":"100.00","currency":"EUR"}',
                ['country' => ['alpha2' => 'DE']],
                true,
                1.15,
                1.00
            ],
            [
                '{"bin":"516793","amount":"50.00","currency":"USD"}',
                ['country' => ['alpha2' => 'DE']],
                true,
                1.15,
                0.44
            ],
            [
                '{"bin":"45717360","amount":"130","currency":"USD"}',
                ['country' => ['alpha2' => 'US']],
                false,
                1.15,
                2.27
            ],
        ];
    }

    /**
     * @dataProvider inputAndCommissionCalculationExceptionProvider
     * @param $transaction
     * @param $binInfo
     */
    public function testCalculateCommissionException($transaction, $binInfo)
    {
        $this->binProviderMock->method('getBinInfo')->willReturn($binInfo);

        $this->expectException(CommissionCalculationException::class);

        $this->testObject->calculateCommission($transaction);
    }

    /**
     * @return array[]
     */
    public function inputAndCommissionCalculationExceptionProvider(): array
    {
        return [
            [
                '{"amount":"100.00","currency":"EUR"}',
                ['country' => ['alpha2' => 'DE']],
            ],
            [
                '{"bin":"516793","currency":"USD"}',
                ['country' => ['alpha2' => 'DE']],
            ],
            [
                '{"bin":"45717360","amount":"130",}',
                ['country' => ['alpha2' => 'US']],
            ],
            [
                '{"bin":"45717360","amount":"130","currency":"USD"}',
                ['country' => []],
            ],
            [
                '{"bin":"45717360","amount":"130","currency":"USD"}',
                [],
            ],
            [
                '{"bin":"45717360","amount":"130","currency":"USD"}',
                null,
            ],
        ];
    }
}
