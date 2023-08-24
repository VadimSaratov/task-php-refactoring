<?php

namespace App\Services\Providers;

use App\Contracts\Services\Providers\BinProvider;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class DefaultBinProvider implements BinProvider
{
    /**
     * @var string
     */
    protected string $baseUrl = 'https://lookup.binlist.net/';

    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * DefaultBinProvider constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $bin
     * @return array
     */
    public function getBinInfo(string $bin): array
    {
        $uri = $this->baseUrl . $bin;

        try {
            $response = $this->client->request('GET', $uri);
            return $this->handleResponse($response);
        } catch (GuzzleException $e) {
            //TODO: Handle Guzzle exceptions
            // Example: Log::error('Guzzle exception: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        if ($statusCode === 200) {
            return json_decode($body, true);
        }

        return [];
    }
}
