<?php

namespace Cerbero\LazyJson\Providers;

use Cerbero\LazyJson\Macro;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\ServiceProvider;

/**
 * The service provider.
 *
 */
class LazyJsonServiceProvider extends ServiceProvider
{
    /**
     * Execute logic after the service provider is booted.
     *
     * @return void
     */
    public function boot()
    {
        LazyCollection::macro('fromJson', new Macro());
    }
}
