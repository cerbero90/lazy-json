<?php

namespace Cerbero\LazyJson\Handlers;

use Illuminate\Http\Client\Response;
use Traversable;

/**
 * The Laravel HTTP client response handler.
 *
 */
class LaravelClientResponse extends Psr7Message
{
    /**
     * Determine whether the handler can handle the given source
     *
     * @param mixed $source
     * @return bool
     */
    public function handles($source): bool
    {
        return $source instanceof Response;
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
        return parent::handle($source->toPsrResponse(), $path);
    }
}
