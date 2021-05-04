<?php

namespace Cerbero\LazyJson;

use Cerbero\LazyJson\Exceptions\LazyJsonException;
use Cerbero\LazyJson\Handlers;
use IteratorAggregate;
use Traversable;

/**
 * The JSON source.
 *
 */
class Source implements IteratorAggregate
{
    /**
     * The traversable JSON.
     *
     * @var Traversable
     */
    protected $traversable;

    /**
     * The source handlers.
     *
     * @var array
     */
    protected $handlers = [
        Handlers\Endpoint::class,
        Handlers\Filename::class,
        Handlers\IterableSource::class,
        Handlers\JsonString::class,
        Handlers\LaravelClientResponse::class,
        Handlers\Psr7Message::class,
        Handlers\Psr7Stream::class,
        Handlers\Resource::class,
    ];

    /**
     * Instantiate the class.
     *
     * @param mixed $source
     * @param string $path
     */
    public function __construct($source, string $path)
    {
        $this->traversable = $this->toTraversable($source, $path);
    }

    /**
     * Turn the given JSON source into a traversable instance
     *
     * @param mixed $source
     * @param string $path
     * @return Traversable
     *
     * @throws LazyJsonException
     */
    protected function toTraversable($source, string $path): Traversable
    {
        foreach ($this->handlers as $class) {
            /** @var Handlers\Handler $handler */
            $handler = new $class();

            if ($handler->handles($source)) {
                return $handler->handle($source, $path);
            }
        }

        throw new LazyJsonException('Unable to load the JSON from the provided source.');
    }

    /**
     * Retrieve the traversable JSON
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return $this->traversable;
    }
}
