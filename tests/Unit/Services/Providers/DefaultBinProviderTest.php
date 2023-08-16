<?php

namespace Tests\Unit\Services\Providers;

use App\Services\Providers\DefaultBinProvider;
use PHPUnit\Framework\TestCase;

class DefaultBinProviderTest extends TestCase
{
    /**
     * @var DefaultBinProvider
     */
    private DefaultBinProvider $testObject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testObject = new DefaultBinProvider();
    }

    public function testGetBinInfo()
    {
        //TODO: update unit test when implementing API call
        $this->assertSame(['country' => ['alpha2' => 'DE']], $this->testObject->getBinInfo("45717360"));
    }
}
