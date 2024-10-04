<?php

namespace HedgehoglabEngineering\DeclaredData\Resolvers;

use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableDataAttributeInterface;
use Illuminate\Support\Collection;

class PropertyAttributeResolver
{
    private static array $cache = [];

    public static function resolve(\ReflectionProperty $property, mixed $value, Collection $context): mixed
    {
        return (new self($property))->resolveValue($value, $context);
    }

    private function __construct(
        private readonly \ReflectionProperty $property
    ) {
        //
    }

    private function resolveValue(mixed $value, Collection $context): mixed
    {
        if (! $attributes = $this->getResolvableAttributes()) {
            return null;
        }

        foreach ($attributes as $attribute) {
            $value = $attribute->resolveValue($value, $context);
        }

        return $value;
    }

    /**
     * @return array<int, \HedgehoglabEngineering\DeclaredData\Contracts\ResolvableDataAttributeInterface>
     */
    private function getResolvableAttributes(): array
    {
        return self::$cache[$this->property->class][$this->property->name] ??= $this->getResolvedAttributes();
    }

    /**
     * @return array<int, \HedgehoglabEngineering\DeclaredData\Contracts\ResolvableDataAttributeInterface>
     */
    private function getResolvedAttributes(): array
    {
        $attributes = array_filter($this->property->getAttributes(), function (\ReflectionAttribute $attribute) {
            return is_subclass_of($attribute->getName(), ResolvableDataAttributeInterface::class);
        });

        return array_map(fn (\ReflectionAttribute $attribute) => $attribute->newInstance(), $attributes);
    }
}
