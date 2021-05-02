<?php

namespace Cerbero\LazyJson\Handlers;

use Illuminate\Http\Client\Response;
use Traversable;

/**
 * The Laravel HTTP client response handler.
 *
 */
class LaravelClientResponse extends AbstractHandler
{
    /**
     * Determine whether the handler should handle the source
     *
     * @return bool
     */
    protected function shouldHandleSource(): bool
    {
        return $this->source instanceof Response;
    }

    /**
     * Handle the source
     *
     * @return Traversable|null
     */
    protected function handleSource(): ?Traversable
    {
        $this->source = $this->source->toPsrResponse();

        return null;
    }
}
