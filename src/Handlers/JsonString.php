<?php

namespace Cerbero\LazyJson\Handlers;

use JsonMachine\JsonMachine;
use Traversable;

/**
 * The JSON string handler.
 *
 */
class JsonString extends AbstractHandler
{
    /**
     * Determine whether the handler should handle the source
     *
     * @return bool
     */
    protected function shouldHandleSource(): bool
    {
        return is_string($this->source);
    }

    /**
     * Handle the source
     *
     * @return Traversable|null
     */
    protected function handleSource(): ?Traversable
    {
        return JsonMachine::fromString($this->source, $this->pointer());
    }
}
