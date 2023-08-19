<?php

use Cerbero\JsonParser\Exceptions\SyntaxException;
use Cerbero\LazyJson\Dataset;
use Cerbero\LazyJson\Exceptions\LazyJsonException;
use Cerbero\LazyJson\LazyJson;
use Illuminate\Support\LazyCollection;
use Pest\Expectation;

use function Cerbero\LazyJson\lazyJson;

it('can be used via lazy collection macro', function () {
    expect(LazyCollection::fromJson('{"foo":123}'))->toBeInstanceOf(LazyCollection::class);
});

it('can be used via static method', function () {
    expect(LazyJson::from('{"foo":123}'))->toBeInstanceOf(LazyCollection::class);
});

it('can be used via namespaced helper', function () {
    expect(lazyJson('{"foo":123}'))->toBeInstanceOf(LazyCollection::class);
});

it('wraps the thrown exception when an error occurs', function () {
    expect(fn () => LazyJson::from('/foo')->all())->toThrow(fn (LazyJsonException $e) => expect($e)
        ->getMessage()->toBe("Syntax error: unexpected '/' at position 0")
        ->exception->toBeInstanceOf(SyntaxException::class)
    );
});

it('iterates through keys and values', function () {
    expect(LazyJson::from('{"foo":123,"bar":321}'))->sequence(
        fn (Expectation $value, Expectation $key) => $key->toBe('foo')->and($value)->toBe(123),
        fn (Expectation $value, Expectation $key) => $key->toBe('bar')->and($value)->toBe(321),
    );
});

it('wraps JSON objects and arrays into lazy collections', function () {
    expect(LazyJson::from('{"foo":{"one":1,"two":2},"bar":[3,4]}'))
        ->traverse(fn (Expectation $value) => $value->toBeWrappedIntoLazyCollection());
});

it('turns dot notation into JSON pointers correctly', function (string $source, string|int $dot, mixed $sequence) {
    expect(LazyJson::from($source, (string) $dot))->sequence($sequence);
})->with(Dataset::forDots());

it('sets a callable JSON pointer by using the dot notation syntax', function () {
    $dots = [
        'foo' => function ($value, $key) {
            expect($key)->toBe('foo')->and($value)->toBeInstanceOf(LazyCollection::class)->values()->all()->toBe([1, 2]);
            return 'foo closure was run';
        },
        'bar' => function ($value, $key) {
            expect($key)->toBe('bar')->and($value)->toBeInstanceOf(LazyCollection::class)->all()->toBe([3, 4]);
            return 'bar closure was run';
        },
    ];

    expect(LazyJson::from('{"foo":{"one":1,"two":2},"bar":[3,4]}', $dots))->traverse(
        fn (Expectation $value, Expectation $key) => $key->toBe('foo')->and($value)->toBe('foo closure was run'),
        fn (Expectation $value, Expectation $key) => $key->toBe('bar')->and($value)->toBe('bar closure was run'),
    );
});

it('sets a JSON pointer by using the dot notation syntax', function (string $source, string $dot, array $expectedValuesByKey) {
    $actualValues = [];
    $expectedKey = key($expectedValuesByKey);
    $expectedValues = reset($expectedValuesByKey);

    expect(LazyJson::from($source, $dot))
        ->traverse(function (Expectation $value, Expectation $key) use (&$actualValues, $expectedKey) {
            $key->toBe($expectedKey)->and($value)->toBeInstanceOf(LazyCollection::class);
            $actualValues[] = $value->value->toArray();
        });

    expect($actualValues)->toBe($expectedValues);
})->with(Dataset::forSingleDots());

it('sets JSON pointers by using the dot notation syntax', function (string $source, array $dots, array $expectedValuesByKey) {
    $actualValues = [];

    expect(LazyJson::from($source, $dots))
        ->traverse(function (Expectation $value, Expectation $key) use (&$actualValues) {
            $value->toBeInstanceOf(LazyCollection::class);
            $actualValues[$key->value][] = $value->value->toArray();
        });

    expect($actualValues)->toBe($expectedValuesByKey);
})->with(Dataset::forMultipleDots());
