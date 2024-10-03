<?php

namespace HedgehoglabEngineering\LaravelDataTools\Resolvers;

use HedgehoglabEngineering\LaravelDataTools\Contracts\CreatableData;

class PropertyTypeResolver
{
    private static array $cache = [];

    public static function resolve(\ReflectionProperty $property, mixed $value): mixed
    {
        return (new self($property))->resolveValue($value);
    }

    private function __construct(
        private readonly \ReflectionProperty $property
    ) {
        //
    }

    private function resolveValue(mixed $value): mixed
    {
        $typeNames = $this->getPropertyTypeNames();

        if (! $typeNames) {
            // the property is not typed, so we'll just return whatever it is
            return $value;
        }

        if ($this->valueIsAlreadyTyped($value, $typeNames)) {
            return $value;
        }

        // we're left with one or more types, so the first one to match will win
        foreach ($typeNames as $typeName) {
            if ($this->isCreatableData($typeName)) {
                return $typeName::create($value);
            }

            if ($this->isDatetime($typeName)) {
                return $this->resolveDateTime($value, $typeName);
            }

            if ($this->isEnum($typeName)) {
                return $typeName::from($value);
            }
        }

        return $value;
    }

    private function valueIsAlreadyTyped(mixed $value, array $typeNames): bool
    {
        if (! is_object($value)) {
            return in_array(get_debug_type($value), $typeNames);
        }

        foreach ($typeNames as $typeName) {
            if (is_a($value, $typeName)) {
                return true;
            }
        }

        return false;
    }

    private function isCreatableData(string $typeName): bool
    {
        return is_a($typeName, CreatableData::class, true);
    }

    private function isDatetime(string $typeName): bool
    {
        return is_a($typeName, \DateTimeInterface::class, true);
    }

    private function isEnum(string $typeName): bool
    {
        return is_subclass_of($typeName, \BackedEnum::class);
    }

    /**
     * @return null|array<int, string>
     */
    private function getPropertyTypeNames(): ?array
    {
        return self::$cache[$this->property->class][$this->property->name] ??= $this->getResolvedPropertyTypeNames();
    }

    /**
     * @return null|array<int, string>
     */
    private function getResolvedPropertyTypeNames(): ?array
    {
        if (! $type = $this->property->getType()) {
            return null;
        }

        /** @var \ReflectionNamedType|\ReflectionIntersectionType|\ReflectionUnionType $type */
        return array_map(
            fn (\ReflectionNamedType $type) => $type->getName(),
            $type instanceof \ReflectionNamedType ? [$type] : $type->getTypes()
        );
    }

    private function resolveDateTime(mixed $value, string $typeName): \DateTimeInterface
    {
        $value = \Carbon\Carbon::parse($value);

        return match (true) {
            is_a($typeName, \Carbon\CarbonImmutable::class, true) => $value->toImmutable(),
            is_a($typeName, \Carbon\CarbonInterface::class, true) => $value,
            is_a($typeName, \DateTimeImmutable::class, true) => $value->toDateTimeImmutable(),
            default => $value->toDateTime(),
        };
    }
}
