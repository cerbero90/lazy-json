<?php

namespace Cerbero\LazyJson\Handlers;

use Cerbero\LazyJson\Concerns\JsonPointerAware;
use JsonMachine\JsonMachine;
use Traversable;

/**
 * The iterable source handler.
 *
 */
class IterableSource implements Handler
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
        return is_iterable($source);
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
        return JsonMachine::fromIterable($source, $this->toJsonPointer($path));
    }
}
