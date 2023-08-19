<?php

declare(strict_types=1);

namespace Cerbero\LazyJson;

use Generator;

final class Dataset
{
    public static function forDots(): Generator
    {
        $simpleObject = require fixture('simple_object.php');
        $source = fixture('simple_object.json');

        foreach ($simpleObject as $key => $value) {
            yield [$source, $key, $value];
        }
    }

    public static function forSingleDots(): Generator
    {
        $singleDot = require fixture('single_dot.php');

        foreach ($singleDot as $fixture => $subtreeByDot) {
            $source = fixture("{$fixture}.json");

            foreach ($subtreeByDot as $dot => $expectedValuesByKey) {
                yield [$source, $dot, $expectedValuesByKey];
            }
        }
    }

    public static function forMultipleDots(): Generator
    {
        $singleDot = require fixture('multiple_dots.php');

        foreach ($singleDot as $fixture => $subtreeByDots) {
            $source = fixture("{$fixture}.json");

            foreach ($subtreeByDots as $dots => $expectedValuesByKey) {
                yield [$source, explode(',', $dots), $expectedValuesByKey];
            }
        }
    }
}
