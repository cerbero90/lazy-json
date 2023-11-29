<?php

namespace Cerbero\LazyJson;

use Illuminate\Support\LazyCollection;

/**
 * @param string|string[]|array<string, \Closure> $dot
 */
function lazyJson(mixed $source, string|array $dot = ''): LazyCollection
{
    return LazyJson::from($source, $dot);
}
