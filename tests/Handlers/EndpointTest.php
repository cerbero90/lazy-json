<?php

namespace Cerbero\LazyJson\Handlers;

use Cerbero\LazyJson\Exceptions\LazyJsonException;
use Cerbero\LazyJson\Handlers\Endpoint;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response as Psr7Response;
use JsonMachine\Items;
use Mockery as m;
use PHPUnit\Framework\TestCase;

/**
 * The lazy JSON test.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
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
        m::mock('overload:' . Client::class, [
            'get' => new Psr7Response(200, [], '{"end":"point"}'),
        ]);

        $handled = (new Endpoint())->handle('https://endpoint.test', '');

        $this->assertInstanceOf(Items::class, $handled);

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
        m::mock('overload:' . Client::class, [
            'get' => new Psr7Response(200, [], '{"foo":{"bar":1,"baz":2}}'),
        ]);

        $handled = (new Endpoint())->handle('https://endpoint.test', 'foo.bar');

        $this->assertInstanceOf(Items::class, $handled);

        foreach ($handled as $key => $value) {
            $this->assertSame('bar', $key);
            $this->assertSame(1, $value);
        }
    }

    /**
     * @test
     */
    public function failsIfGuzzleIsNotLoaded()
    {
        $double = m::mock(Endpoint::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('guzzleIsLoaded')
            ->once()
            ->andReturn(false)
            ->getMock();

        $this->expectExceptionObject(new LazyJsonException('Guzzle is required to load JSON from endpoints'));

        $double->handle('https://endpoint.test', 'foo.bar');
    }
}
