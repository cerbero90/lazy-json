<?php

namespace Cerbero\LazyJson;

use Cerbero\LazyJson\Exceptions\LazyJsonException;
use Cerbero\LazyJson\Providers\LazyJsonServiceProvider;
use GuzzleHttp\Psr7\Response as Psr7Response;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Http\Client\Response;
use Orchestra\Testbench\TestCase;
use Throwable;

/**
 * The lazy JSON test.
 *
 */
class LazyJsonTest extends TestCase
{
    /**
     * Retrieve the package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LazyJsonServiceProvider::class,
        ];
    }

    /**
     * @test
     */
    public function lazyLoadsJsonFromFilename()
    {
        lazyJson(__DIR__ . '/stub.json')->each(function ($value, $key) {
            $this->assertSame('key', $key);
            $this->assertSame('JSON file value', $value);
        });
    }

    /**
     * @test
     */
    public function lazyLoadsJsonFromIterable()
    {
        lazyJson(['{"foo":"bar"}'])->each(function ($value, $key) {
            $this->assertSame('foo', $key);
            $this->assertSame('bar', $value);
        });
    }

    /**
     * @test
     */
    public function lazyLoadsJsonFromString()
    {
        lazyJson('{"bar":"baz"}')->each(function ($value, $key) {
            $this->assertSame('bar', $key);
            $this->assertSame('baz', $value);
        });
    }

    /**
     * @test
     */
    public function lazyLoadsJsonFromLaravelClientResponse()
    {
        $response = new Response(new Psr7Response(200, [], '{"status":"success"}'));

        lazyJson($response)->each(function ($value, $key) {
            $this->assertSame('status', $key);
            $this->assertSame('success', $value);
        });
    }

    /**
     * @test
     */
    public function lazyLoadsJsonFromPsr7Message()
    {
        $response = new Psr7Response(200, [], '{"one":"two"}');

        lazyJson($response)->each(function ($value, $key) {
            $this->assertSame('one', $key);
            $this->assertSame('two', $value);
        });
    }

    /**
     * @test
     */
    public function lazyLoadsJsonFromPsr7Stream()
    {
        $stream = Utils::streamFor('{"stream":"ok"}');

        lazyJson($stream)->each(function ($value, $key) {
            $this->assertSame('stream', $key);
            $this->assertSame('ok', $value);
        });
    }

    /**
     * @test
     */
    public function lazyLoadsJsonFromResource()
    {
        $resource = fopen(__DIR__ . '/stub.json', 'rb');

        lazyJson($resource)->each(function ($value, $key) {
            $this->assertSame('key', $key);
            $this->assertSame('JSON file value', $value);
        });
    }

    /**
     * @test
     */
    public function failsWithInvalidJsonSource()
    {
        $this->expectExceptionObject(new LazyJsonException('Unable to load the JSON from the provided source.'));

        lazyJson(123)->all();
    }

    /**
     * @test
     */
    public function trowsPackageExceptionWhenAnyExceptionOccursDuringJsonLoading()
    {
        try {
            lazyJson('{}}')->all();
        } catch (Throwable $e) {
            $this->assertInstanceOf(LazyJsonException::class, $e);
            $this->assertSame($e->getPrevious()->getMessage(), $e->getMessage());
        }
    }
}
