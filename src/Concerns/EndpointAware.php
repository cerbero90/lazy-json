<?php

namespace Cerbero\LazyJson\Concerns;

/**
 * The endpoint aware trait.
 *
 */
trait EndpointAware
{
    /**
     * Determine whether the given item may point to an endpoint
     *
     * @param mixed $item
     * @return bool
     */
    public function isEndpoint($item): bool
    {
        if (!is_string($item) || ($url = parse_url($item)) === false) {
            return false;
        }

        return in_array($url['scheme'] ?? null, ['http', 'https']) && isset($url['host']);
    }
}
