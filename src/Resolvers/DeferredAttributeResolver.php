<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Resolvers;

use Closure;
use Illuminate\Support\Collection;

class DeferredAttributeResolver
{
    public function __construct(
        private readonly mixed $value,
        private readonly Closure $callback
    ) {
        //
    }

    public function resolve(Collection $context): mixed
    {
        return call_user_func($this->callback, $this->value, $context);
    }
}
