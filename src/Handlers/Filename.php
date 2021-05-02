<?php

namespace Cerbero\LazyJson\Handlers;

use JsonMachine\JsonMachine;
use Traversable;

/**
 * The filename handler.
 *
 */
class Filename extends AbstractHandler
{
    /**
     * Determine whether the handler should handle the source
     *
     * @return bool
     */
    protected function shouldHandleSource(): bool
    {
        return is_string($this->source) && is_file($this->source);
    }

    /**
     * Handle the source
     *
     * @return Traversable|null
     */
    protected function handleSource(): ?Traversable
    {
        return JsonMachine::fromFile($this->source, $this->pointer());
    }
}
