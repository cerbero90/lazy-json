<?php

declare(strict_types=1);

namespace Cerbero\LazyJson;

use Cerbero\LazyJson\Exceptions\LazyJsonException;
use Cerbero\LazyJson\Sources\Source;
use Illuminate\Support\LazyCollection;
use Throwable;

final class Macro
{
    public function __invoke(mixed $source, string $dot = ''): LazyCollection
    {
        return new LazyCollection(function () use ($source, $dot) {
            try {
                yield from new Source($source, $dot);
            } catch (Throwable $e) {
                throw new LazyJsonException($e->getMessage());
            }
        });
    }
}
