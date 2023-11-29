<?php

use Cerbero\LazyJson\LazyJson;
use Illuminate\Support\LazyCollection;

(static function () {
    LazyCollection::macro('fromJson', [LazyJson::class, 'from']);
})();
