<?php

declare(strict_types=1);

namespace Cerbero\LazyJson;

use Cerbero\JsonParser\JsonParser;
use Cerbero\JsonParser\Tokens\Parser;
use Cerbero\LazyJson\Exceptions\LazyJsonException;
use Cerbero\LazyJson\Pointers\DotsConverter;
use Illuminate\Support\LazyCollection;
use IteratorAggregate;
use Throwable;
use Traversable;

/**
 * @implements IteratorAggregate<string|int, mixed>
 */
final class LazyJson implements IteratorAggregate
{
    private JsonParser $parser;

    /**
     * @param string|string[]|array<string, \Closure> $dot
     * @return LazyCollection<string|int, mixed>
     */
    public static function from(mixed $source, string|array $dot = '*'): LazyCollection
    {
        return new LazyCollection(fn () => yield from new self($source, (array) $dot));
    }

    /**
     * @param string[]|array<string, \Closure> $dots
     */
    private function __construct(mixed $source, array $dots)
    {
        $this->parser = JsonParser::parse($source)
            ->lazyPointers(DotsConverter::toPointers($dots))
            ->wrap(fn (Parser $parser) => new LazyCollection(fn () => yield from $parser));
    }

    /**
     * @return Traversable<string|int, mixed>
     */
    public function getIterator(): Traversable
    {
        try {
            yield from $this->parser;
        } catch (Throwable $e) {
            throw new LazyJsonException($e);
        }
    }
}
