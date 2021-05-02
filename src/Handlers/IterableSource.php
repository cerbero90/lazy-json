<?php

namespace Cerbero\LazyJson\Handlers;

use JsonMachine\JsonMachine;
use Traversable;

/**
 * The iterable source handler.
 *
 */
class IterableSource extends AbstractHandler
{
    /**
     * Determine whether the handler should handle the source
     *
     * @return bool
     */
    protected function shouldHandleSource(): bool
    {
        return is_iterable($this->source);
    }

    /**
     * Handle the source
     *
     * @return Traversable|null
     */
    protected function handleSource(): ?Traversable
    {
        return JsonMachine::fromIterable($this->source, $this->pointer());
    }
}
