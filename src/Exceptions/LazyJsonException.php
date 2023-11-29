<?php

declare(strict_types=1);

namespace Cerbero\LazyJson\Exceptions;

use Exception;
use Throwable;

final class LazyJsonException extends Exception
{
    public function __construct(public readonly Throwable $exception)
    {
        parent::__construct($exception->getMessage());
    }
}
