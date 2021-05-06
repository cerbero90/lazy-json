<?php

namespace Cerbero\LazyJson\Handlers;

use Cerbero\LazyJson\StreamWrapper;
use Psr\Http\Message\StreamInterface;
use Traversable;

/**
 * The PSR-7 stream handler.
 *
 */
class Psr7Stream extends Resource
{
    /**
     * Determine whether the handler can handle the given source
     *
     * @param mixed $source
     * @return bool
     */
    public function handles($source): bool
    {
        return $source instanceof StreamInterface;
    }

    /**
     * Handle the given source
     *
     * @param mixed $source
     * @param string $path
     * @return Traversable
     */
    public function handle($source, string $path): Traversable
    {
        if (!in_array(StreamWrapper::NAME, stream_get_wrappers())) {
            stream_wrapper_register(StreamWrapper::NAME, StreamWrapper::class);
        }

        $stream = fopen(StreamWrapper::NAME . '://stream', 'rb', false, stream_context_create([
            StreamWrapper::NAME => ['stream' => $source],
        ]));

        return parent::handle($stream, $path);
    }
}
