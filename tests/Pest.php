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
 * Expect the given sequence from a Traversable
 * Temporary fix to sequence() until this PR is merged: https://github.com/pestphp/pest/pull/895
 */
expect()->extend('traverse', function (mixed ...$callbacks) {
    if (! is_iterable($this->value)) {
        throw new BadMethodCallException('Expectation value is not iterable.');
    }

    if (empty($callbacks)) {
        throw new InvalidArgumentException('No sequence expectations defined.');
    }

    $index = $valuesCount = 0;

    foreach ($this->value as $key => $value) {
        $valuesCount++;

        if ($callbacks[$index] instanceof Closure) {
            $callbacks[$index](new self($value), new self($key));
        } else {
            (new self($value))->toEqual($callbacks[$index]);
        }

        $index = isset($callbacks[$index + 1]) ? $index + 1 : 0;
    }

    if (count($callbacks) > $valuesCount) {
        throw new OutOfRangeException('Sequence expectations are more than the iterable items');
    }

    return $this;
});

/**
 * Expect that all Parser instances are wrapped recursively into lazy collections
 */
expect()->extend('toBeWrappedIntoLazyCollection', function () {
    return $this->when(is_object($this->value), fn (Expectation $value) => $value
        ->toBeInstanceOf(LazyCollection::class)
        ->not->toBeInstanceOf(Parser::class)
        ->traverse(fn (Expectation $value) => $value->toBeWrappedIntoLazyCollection())
    );
});
