<?php

namespace Cerbero\LazyJson\Handlers;

use Psr\Http\Message\MessageInterface;
use Traversable;

/**
 * The PSR-7 message handler.
 *
 */
class Psr7Message extends Psr7Stream
{
    /**
     * Determine whether the handler can handle the given source
     *
     * @param mixed $source
     * @return bool
     */
    public function handles($source): bool
    {
        return $source instanceof MessageInterface;
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
        return parent::handle($source->getBody(), $path);
    }
}
