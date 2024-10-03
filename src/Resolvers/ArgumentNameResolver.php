<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\LaravelDataTools\Resolvers;

use HedgehoglabEngineering\LaravelDataTools\Attributes\MapArgumentName;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ArgumentNameResolver
{
    public static function resolve(string $class, iterable $arguments): array
    {
        return (new self())->resolveArgumentNames(class: $class, arguments: $arguments);
    }

    public function resolveArgumentNames(string $class, iterable $arguments): array
    {
        $class = new \ReflectionClass($class);

        $properties = $this->getProperties(class: $class);

        return Collection::make(items: $arguments)
            ->mapWithKeys(function (mixed $value, string $argument) use ($properties): array {
                $argumentName = $properties[$argument] ?? $argument;

                if (! $argumentName) {
                    return [];
                }

                return [$argumentName => $value];
            })
            ->all();
    }

    private function getProperties(\ReflectionClass $class): array
    {
        return Arr::mapWithKeys(
            array: $class->getProperties(),
            callback: fn (\ReflectionProperty $property): array => [$this->getArgumentName(property: $property) => $property->getName()],
        );
    }

    private function getArgumentName(\ReflectionProperty $property): string
    {
        $argumentNameAttribute = array_filter(
            array: $property->getAttributes(),
            callback: fn (\ReflectionAttribute $attribute) => $attribute->getName() === MapArgumentName::class,
        )[0] ?? null;

        if (! $argumentNameAttribute) {
            return $property->getName();
        }

        /** @var MapArgumentName $argumentName */
        $argumentName = $argumentNameAttribute->newInstance();

        return $argumentName->resolveValue();
    }
}
