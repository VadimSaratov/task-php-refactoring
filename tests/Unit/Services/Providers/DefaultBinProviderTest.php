<?php

namespace Tests\Unit\Services\Providers;

use App\Services\Providers\DefaultBinProvider;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class DefaultBinProviderTest extends TestCase
{
    /**
     * @var DefaultBinProvider
     */
    private DefaultBinProvider $testObject;

    /**
     * @var ClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $mockClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockClient = $this->createMock(ClientInterface::class);

        $this->testObject = new DefaultBinProvider($this->mockClient);
    }

    public function testGetBinInfo()
    {
        $mockResponse = new Response(200, [], '{"country": {"alpha2": "DE"}}');

        $this->mockClient->expects($this->once())
            ->method('request')
            ->willReturn($mockResponse);

        $result = $this->testObject->getBinInfo("45717360");

        $this->assertSame(['country' => ['alpha2' => 'DE']], $result);
    }

    public function testGetBinInfoWithGuzzleException()
    {
        $exceptionMock = $this->createMock(GuzzleException::class);

        $this->mockClient->expects($this->once())
            ->method('request')
            ->willThrowException($exceptionMock);

        $result = $this->testObject->getBinInfo("2222222");

        $this->assertSame([], $result);
    }
}
