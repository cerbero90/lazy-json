<?php

namespace Cerbero\LazyJson\Handlers;

use Cerbero\LazyJson\Concerns\EndpointAware;
use Cerbero\LazyJson\Exceptions\LazyJsonException;
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
     * Determine whether the handler can handle the given source
     *
     * @param mixed $source
     * @return bool
     */
    public function handles($source): bool
    {
        return $this->isEndpoint($source);
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
        if (!$this->guzzleIsLoaded()) {
            throw new LazyJsonException('Guzzle is required to load JSON from endpoints');
        }

        $response = (new Client())->get($source, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return parent::handle($response, $path);
    }

    /**
     * Determine whether Guzzle is loaded, useful for testing
     *
     * @return bool
     */
    protected function guzzleIsLoaded(): bool
    {
        return class_exists(Client::class);
    }
}
