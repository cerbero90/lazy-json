<?php

namespace Cerbero\LazyJson\Handlers;

use Traversable;

/**
 * The handler interface.
 *
 */
interface Handler
{
    /**
     * Determine whether the handler can handle the given source
     *
     * @param mixed $source
     * @return bool
     */
    public function handles($source): bool;

    /**
     * Handle the given source
     *
     * @param mixed $source
     * @param string $path
     * @return Traversable
     */
    public function handle($source, string $path): Traversable;
}
