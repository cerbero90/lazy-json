<?php

declare(strict_types=1);

namespace Cerbero\LazyJson\Pointers;

use Closure;

final class DotsConverter
{
    /**
     * @param string[]|array<string, Closure> $dots
     * @return string[]|array<string, Closure>
     */
    public static function toPointers(array $dots): array
    {
        $pointers = [];

        foreach ($dots as $dot => $callback) {
            if ($callback instanceof Closure) {
                $pointers[self::toPointer($dot)] = $callback;
            } else {
                $pointers[] = self::toPointer($callback);
            }
        }

        return $pointers;
    }

    public static function toPointer(string $dot): string
    {
        $search = ['~', '/', '.', '*', '\\', '"'];
        $replace = ['~0', '~1', '/', '-', '\\\\', '\"'];

        return $dot == '*' ? '' : '/' . str_replace($search, $replace, $dot);
    }
}
