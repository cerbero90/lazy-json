<?php

namespace Cerbero\LazyJson\Handlers;

use Cerbero\LazyJson\Concerns\JsonPointerAware;
use JsonMachine\JsonMachine;
use Traversable;

/**
 * The resource handler.
 *
 */
class Resource implements Handler
{
    use JsonPointerAware;

    /**
     * Determine whether the handler can handle the given source
     *
     * @param mixed $source
     * @return bool
     */
    public function handles($source): bool
    {
        return is_resource($source);
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
        return JsonMachine::fromStream($source, $this->toJsonPointer($path));
    }
}
