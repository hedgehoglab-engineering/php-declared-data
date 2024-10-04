<?php

namespace HedgehoglabEngineering\DeclaredData\Attributes;

use HedgehoglabEngineering\DeclaredData\Contracts\CollectableData;
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableDataAttributeInterface;
use Attribute;
use Illuminate\Support\Collection;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CollectionOf implements ResolvableDataAttributeInterface
{
    /**
     * @param class-string $class
     */
    public function __construct(private readonly string $class)
    {
        //
    }

    /**
     * @return Collection
     */
    public function resolveValue(mixed $value, Collection $context): mixed
    {
        $class = $this->class;

        if (is_a($class, CollectableData::class, true)) {
            return $class::collect($value);
        }

        if (is_subclass_of($class, \BackedEnum::class)) {
            return Collection::make($value)->map(
                fn (\BackedEnum|string $enum) => is_subclass_of($enum, \BackedEnum::class)
                    ? $enum
                    : $class::from($enum)
            );
        }

        return Collection::make($value);
    }
}
