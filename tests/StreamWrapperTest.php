<?php

namespace Cerbero\LazyJson;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Mockery as m;

/**
 * The stream wrapper test.
 *
 */
class StreamWrapperTest extends TestCase
{
    /**
     * Set the tests up
     *
     * @return void
     */
    public function setUp(): void
    {
        if (!in_array(StreamWrapper::NAME, stream_get_wrappers())) {
            stream_wrapper_register(StreamWrapper::NAME, StreamWrapper::class);
        }
    }

    /**
     * Tear the tests down
     *
     * @return void
     */
    public function tearDown(): void
    {
        if (in_array(StreamWrapper::NAME, stream_get_wrappers())) {
            stream_wrapper_unregister(StreamWrapper::NAME);
        }

        m::close();
    }

    /**
     * @test
     */
    public function canOpenStream()
    {
        $double = m::mock(StreamInterface::class, [
            'isReadable' => true,
        ]);

        $resource = $this->openStreamWith($double);

        $this->assertTrue(is_resource($resource));
    }

    /**
     * Open the stream with the given wrapper
     *
     * @param mixed $stream
     * @return resource|bool
     */
    protected function openStreamWith($stream)
    {
        return @fopen(StreamWrapper::NAME . '://stream', 'rb', false, stream_context_create([
            StreamWrapper::NAME => compact('stream'),
        ]));
    }

    /**
     * @test
     */
    public function cannotOpenInvalidStream()
    {
        $bool = $this->openStreamWith(new \stdClass());

        $this->assertFalse($bool);
    }

    /**
     * @test
     */
    public function cannotOpenUnreadableStream()
    {
        $double = m::mock(StreamInterface::class, [
            'isReadable' => false,
        ]);

        $bool = $this->openStreamWith($double);

        $this->assertFalse($bool);
    }

    /**
     * @test
     */
    public function canReadEof()
    {
        $double = m::mock(StreamInterface::class, [
            'isReadable' => true,
            'eof' => true,
        ]);

        $resource = $this->openStreamWith($double);

        $this->assertTrue(is_resource($resource));
        $this->assertTrue(feof($resource));
    }

    /**
     * @test
     */
    public function canRead()
    {
        $double = m::mock(StreamInterface::class, [
            'isReadable' => true,
            'eof' => true,
        ])
            ->shouldReceive('read')
            ->andReturn('abc')
            ->getMock();

        $resource = $this->openStreamWith($double);

        $this->assertTrue(is_resource($resource));
        $this->assertSame('abc', fread($resource, 3));
    }
}
