<?php

namespace Cerbero\LazyJson\Handlers;

use Cerbero\LazyJson\Concerns\EndpointAware;
use GuzzleHttp\Client;
use Traversable;

/**
 * The endpoint handler.
 *
 */
class Endpoint extends Psr7Message
{
    use EndpointAware;

    /**
     * The HTTP client.
     *
     * @var Client
     */
    private $client;

    /**
     * Instantiate the class.
     *
     * @param Client $client
     */
    public function __construct(Client $client = null)
    {
        if ($client === null && class_exists(Client::class)) {
            $client = new Client();
        }

        $this->client = $client;
    }

    /**
     * Determine whether the handler can handle the given source
     *
     * @param mixed $source
     * @return bool
     */
    public function handles($source): bool
    {
        return $this->isEndpoint($source) && class_exists(Client::class);
    }

    /**
     * Handle the given source
     *
     * @param mixed $source
     * @param string $path
     * @return Traversable
     */
    public function handle($source, string $path): Traversable
    {
        $response = $this->client->get($source, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return parent::handle($response, $path);
    }
}
