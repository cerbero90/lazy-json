<?php

namespace Cerbero\LazyJson\Handlers;

use GuzzleHttp\Client;
use Traversable;

/**
 * The endpoint handler.
 *
 */
class Endpoint extends AbstractHandler
{
    /**
     * Determine whether the handler should handle the source
     *
     * @return bool
     */
    protected function shouldHandleSource(): bool
    {
        if (!is_string($this->source)) {
            return false;
        }

        if (false === $url = parse_url($this->source)) {
            return false;
        }

        return in_array($url['scheme'] ?? null, ['http', 'https']) && isset($url['host']);
    }

    /**
     * Handle the source
     *
     * @return Traversable|null
     */
    protected function handleSource(): ?Traversable
    {
        if (!class_exists(Client::class)) {
            return null;
        }

        $this->source = (new Client())->get($this->source, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        return null;
    }
}
