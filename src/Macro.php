<?php

namespace Cerbero\LazyJson;

use Cerbero\LazyJson\Exceptions\LazyJsonException;
use Illuminate\Support\LazyCollection;
use Throwable;

/**
 * The lazy collection macro.
 *
 */
class Macro
{
    /**
     * Load the given JSON source in a lazy collection
     *
     * @param mixed $source
     * @param string $path
     * @return LazyCollection
     */
    public function __invoke($source, string $path = ''): LazyCollection
    {
        return new LazyCollection(function () use ($source, $path) {
            try {
                yield from new Source($source, $path);
            } catch (Throwable $e) {
                throw new LazyJsonException($e->getMessage(), 0, $e);
            }
        });
    }
}
