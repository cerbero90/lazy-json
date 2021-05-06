<?php

namespace Cerbero\LazyJson\Concerns;

/**
 * The JSON pointer aware trait.
 *
 */
trait JsonPointerAware
{
    /**
     * Retrieve a JSON pointer from the given dot-noted path.
     *
     * @param string $path
     * @return string
     */
    protected function toJsonPointer(string $path): string
    {
        if (empty($path = trim($path))) {
            return '';
        }

        return '/' . str_replace(['~', '/', '.', '*'], ['~0', '~1', '/', '-'], $path);
    }
}
