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

        // @todo replace * with - after https://github.com/halaxa/json-machine/pull/47 is merged:
        // return '/' . str_replace(['~', '/', '.', '*'], ['~0', '~1', '/', '-'], $path);
        return '/' . str_replace(['~', '/', '.'], ['~0', '~1', '/'], $path);
    }
}
