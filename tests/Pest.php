<?php

use Cerbero\JsonParser\Tokens\Parser;
use Illuminate\Support\LazyCollection;
use Pest\Expectation;

if (!function_exists('fixture')) {
    function fixture(string $fixture): string
    {
        return __DIR__ . "/fixtures/{$fixture}";
    }
}

/**
 * Expect that all Parser instances are wrapped recursively into lazy collections
 */
expect()->extend('toBeWrappedIntoLazyCollection', function () {
    return $this->when(is_object($this->value), fn (Expectation $value) => $value
        ->toBeInstanceOf(LazyCollection::class)
        ->not->toBeInstanceOf(Parser::class)
        ->sequence(fn (Expectation $value) => $value->toBeWrappedIntoLazyCollection())
    );
});
