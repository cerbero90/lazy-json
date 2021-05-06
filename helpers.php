<?php

use Illuminate\Support\LazyCollection;

if (!function_exists('lazyJson')) {
    /**
     * Load the given JSON source in a lazy collection.
     *
     * @param mixed $source
     * @param string $path
     * @return LazyCollection
     */
    function lazyJson($source, string $path = ''): LazyCollection
    {
        return LazyCollection::fromJson($source, $path);
    }
}
