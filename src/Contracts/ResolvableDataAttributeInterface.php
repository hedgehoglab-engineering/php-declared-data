<?php

namespace HedgehoglabEngineering\LaravelDto\Contracts;

use Illuminate\Support\Collection;

interface ResolvableDataAttributeInterface
{
    public function resolveValue(mixed $value, Collection $context): mixed;
}
