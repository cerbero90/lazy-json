<?php

use Illuminate\Support\LazyCollection;

return [
    'int' => 1,
    'empty_string' => '',
    'string' => 'foo',
    'escaped_string' => '"bar"',
    '"escaped_key"' => 'baz',
    "unicode" => "hej då",
    'float' => 3.14,
    'bool' => false,
    'null' => null,
    'empty_array' => new LazyCollection(function () {}),
    'empty_object' => new LazyCollection(function () {}),
    '' => 0,
    'a/b' => 1,
    'c%d' => 2,
    'e^f' => 3,
    'g|h' => 4,
    'i\\j' => 5,
    'k"l' => 6,
    ' ' => 7,
    'm~n' => 8
];
