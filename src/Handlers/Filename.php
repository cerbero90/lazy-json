<?php

namespace Cerbero\LazyJson\Handlers;

use Cerbero\LazyJson\Concerns\JsonPointerAware;
use JsonMachine\Items;
use Traversable;

/**
 * The filename handler.
 *
 */
class Filename implements Handler
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
        return is_string($source) && is_file($source);
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
        return Items::fromFile($source, ['pointer' => $this->toJsonPointer($path)]);
    }
}
