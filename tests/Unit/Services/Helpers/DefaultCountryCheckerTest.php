<?php

namespace Tests\Unit\Services\Helpers;

use App\Services\Helpers\DefaultCountryChecker;
use PHPUnit\Framework\TestCase;

class DefaultCountryCheckerTest extends TestCase
{
    /**
     * @var DefaultCountryChecker
     */
    private DefaultCountryChecker $testObject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testObject = new DefaultCountryChecker();
    }

    /**
     * @dataProvider isEuCountryDataProvider
     */
    public function testIsEuCountry($input, $expected)
    {
        $this->assertEquals($expected, $this->testObject->isEuCountry($input));
    }

    /**
     * @return array[]
     */
    public function isEuCountryDataProvider(): array
    {
        return [
            ['DE', true],
            ['US', false]
        ];
    }
}
