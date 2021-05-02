<?php

namespace Cerbero\LazyJson\Handlers;

use Traversable;

/**
 * The abstract handler.
 *
 */
abstract class AbstractHandler
{
    /**
     * The JSON source.
     *
     * @var mixed
     */
    protected $source;

    /**
     * The dot-noted path.
     *
     * @var string
     */
    protected $path;

    /**
     * Instantiate the class.
     *
     * @param mixed $source
     * @param string $path
     */
    public function __construct(&$source, string $path)
    {
        $this->source = &$source;
        $this->path = $path;
    }

    /**
     * Determine whether the handler should handle the source
     *
     * @return bool
     */
    abstract protected function shouldHandleSource(): bool;

    /**
     * Handle the source
     *
     * @return Traversable|null
     */
    abstract protected function handleSource(): ?Traversable;

    /**
     * Instantiate the class
     *
     * @param mixed $source
     * @param string $path
     * @return self
     */
    public static function of(&$source, string $path): self
    {
        return new static($source, $path);
    }

    /**
     * Attempts to retrieve a traversable JSON from the source
     *
     * @return Traversable|null
     */
    public function handle(): ?Traversable
    {
        return $this->shouldHandleSource() ? $this->handleSource() : null;
    }

    /**
     * Retrieve the JSON pointer of the dot-noted path
     *
     * @param string $path
     * @return string
     */
    protected function pointer(): string
    {
        $path = trim($this->path);

        if (empty($path)) {
            return '';
        }

        return '/' . str_replace(['~', '/', '.', '*'], ['~0', '~1', '/', '-'], $path);
    }
}
