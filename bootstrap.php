<?php

use Cerbero\LazyJson\Macro;
use Illuminate\Support\LazyCollection;

(static function () {
    LazyCollection::macro('fromJson', new Macro());
})();
