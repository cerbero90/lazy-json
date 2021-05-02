<?php

namespace Cerbero\LazyJson\Handlers;

use JsonMachine\JsonMachine;
use Traversable;

/**
 * The resource handler.
 *
 */
class Resource extends AbstractHandler
{
    /**
     * Determine whether the handler should handle the source
     *
     * @return bool
     */
    protected function shouldHandleSource(): bool
    {
        return is_resource($this->source);
    }

    /**
     * Handle the source
     *
     * @return Traversable|null
     */
    protected function handleSource(): ?Traversable
    {
        return JsonMachine::fromStream($this->source, $this->pointer());
    }
}
