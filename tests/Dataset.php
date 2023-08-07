<?php

declare(strict_types=1);

namespace Cerbero\LazyJson;

use Generator;
use Illuminate\Support\LazyCollection;

final class Dataset
{
    public static function forDots(): Generator
    {
        $simpleObject = require fixture('simple_object.php');
        $source = fixture('simple_object.json');

        foreach ($simpleObject as $key => $value) {
            yield [$source, $key, $value];
        }

        $singleDot = require fixture('single_dot.php');

        foreach ($singleDot as $fixture => $subtreeByDot) {
            $source = fixture("{$fixture}.json");

            foreach ($subtreeByDot as $dot => $subtree) {
                $values = (array) reset($subtree);

                foreach ($values as $expected) {
                    yield [
                        $source,
                        $dot,
                        fn ($value, $key) => $key->toBe(key($subtree))
                            ->and($value)
                            ->when(is_array($expected), fn ($value) => $value->toBeInstanceOf(LazyCollection::class))
                            ->and(is_array($expected) ? $value->value->toArray() : $value)
                            ->toBe($expected),
                    ];
                }
            }
        }
    }
}
