<?php

use Illuminate\Support\LazyCollection;

it('autoloads the lazy collection macro', function () {
    expect(LazyCollection::fromJson('{"foo":123}'))->toBeInstanceOf(LazyCollection::class);
});
