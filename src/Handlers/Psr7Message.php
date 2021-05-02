<?php

namespace Cerbero\LazyJson\Handlers;

use Psr\Http\Message\MessageInterface;
use Traversable;

/**
 * The PSR-7 message handler.
 *
 */
class Psr7Message extends AbstractHandler
{
    /**
     * Determine whether the handler should handle the source
     *
     * @return bool
     */
    protected function shouldHandleSource(): bool
    {
        return $this->source instanceof MessageInterface;
    }

    /**
     * Handle the source
     *
     * @return Traversable|null
     */
    protected function handleSource(): ?Traversable
    {
        $this->source = $this->source->getBody();

        return null;
    }
}
