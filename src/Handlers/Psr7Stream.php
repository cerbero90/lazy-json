<?php

namespace Cerbero\LazyJson\Handlers;

use Cerbero\LazyJson\StreamWrapper;
use Psr\Http\Message\StreamInterface;
use Traversable;

/**
 * The PSR-7 stream handler.
 *
 */
class Psr7Stream extends AbstractHandler
{
    /**
     * Determine whether the handler should handle the source
     *
     * @return bool
     */
    protected function shouldHandleSource(): bool
    {
        return $this->source instanceof StreamInterface;
    }

    /**
     * Handle the source
     *
     * @return Traversable|null
     */
    protected function handleSource(): ?Traversable
    {
        if (!in_array(StreamWrapper::NAME, stream_get_wrappers())) {
            stream_wrapper_register(StreamWrapper::NAME, StreamWrapper::class);
        }

        $this->source = fopen(StreamWrapper::NAME . '://stream', 'rb', false, stream_context_create([
            StreamWrapper::NAME => ['stream' => $this->source],
        ]));

        return null;
    }
}
