<?php

namespace HedgehoglabEngineering\DeclaredData\Contracts;

use Illuminate\Support\Collection;

interface ResolvableDataAttributeInterface
{
    public function resolveValue(mixed $value, Collection $context): mixed;
}
