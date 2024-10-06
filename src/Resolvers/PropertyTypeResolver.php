<?php

namespace HedgehoglabEngineering\DeclaredData\Resolvers;

class PropertyTypeResolver
{
    private static array $cache = [];

    private static array $resolvers = [];

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
        if (! $types = $this->getPropertyTypeNames()) {
            // the property is not typed, so we'll just return whatever it is
            return $value;
        }

        if ($this->valueIsAlreadyTyped($value, $types)) {
            return $value;
        }

        foreach ($types as $type) {
            try {
                return $this->getResolver($type)->resolve($value);
            } catch (Strategy\TypeResolverException) {
                // we'll try to resolve each available type and, if none of them
                // can be resolved, just let php throw a native type error
            }
        }

        return $value;
    }

    private function getResolver(string $type): Strategy\AbstractTypeResolver
    {
        return self::$resolvers[$type] ??= match (true) {
            Strategy\CreatableDataResolver::resolvesType($type) => new Strategy\CreatableDataResolver($type),
            Strategy\DateTimeResolver::resolvesType($type) => new Strategy\DateTimeResolver($type),
            Strategy\BackedEnumResolver::resolvesType($type) => new Strategy\BackedEnumResolver($type),
            default => new Strategy\DefaultTypeResolver($type),
        };
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
}
