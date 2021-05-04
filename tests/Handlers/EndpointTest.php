<?php

namespace Cerbero\LazyJson\Handlers;

use Cerbero\LazyJson\Handlers\Endpoint;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response as Psr7Response;
use JsonMachine\JsonMachine;
use Mockery as m;
use Orchestra\Testbench\TestCase;

/**
 * The lazy JSON test.
 *
 */
class EndpointTest extends TestCase
{
    /**
     * Tear the tests down
     *
     * @return void
     */
    public function tearDown(): void
    {
        m::close();
    }

    /**
     * @test
     */
    public function canHandleOnlyEndpoints()
    {
        $handler = new Endpoint();

        $this->assertTrue($handler->handles('http://endpoint.test'));
        $this->assertTrue($handler->handles('https://endpoint.test'));
        $this->assertFalse($handler->handles(123));
        $this->assertFalse($handler->handles('http://'));
        $this->assertFalse($handler->handles('https://'));
        $this->assertFalse($handler->handles('ftp://foo.test'));
    }

    /**
     * @test
     */
    public function handleEndpoint()
    {
        $double = m::mock(Client::class, [
            'get' => new Psr7Response(200, [], '{"end":"point"}'),
        ]);

        $handler = new Endpoint($double);
        $handled = $handler->handle('https://endpoint.test', '');

        $this->assertInstanceOf(JsonMachine::class, $handled);

        foreach ($handled as $key => $value) {
            $this->assertSame('end', $key);
            $this->assertSame('point', $value);
        }
    }

    /**
     * @test
     */
    public function extractsJsonSubtrees()
    {
        $double = m::mock(Client::class, [
            'get' => new Psr7Response(200, [], '{"foo":{"bar":1,"baz":2}}'),
        ]);

        $handler = new Endpoint($double);
        $handled = $handler->handle('https://endpoint.test', 'foo.bar');

        $this->assertInstanceOf(JsonMachine::class, $handled);

        foreach ($handled as $key => $value) {
            $this->assertSame('bar', $key);
            $this->assertSame(1, $value);
        }
    }
}
