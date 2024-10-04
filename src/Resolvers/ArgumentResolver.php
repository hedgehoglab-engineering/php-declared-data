<?php

namespace HedgehoglabEngineering\DeclaredData\Resolvers;

use Illuminate\Support\Collection;

class ArgumentResolver
{
    public static function resolve(string $class, iterable $arguments): array
    {
        return (new self())->resolveArguments($class, $arguments);
    }

    private function resolveArguments(string $class, iterable $arguments): array
    {
        $class = new \ReflectionClass($class);

        return Collection::make($arguments)
            ->reduceWithKeys(function (Collection $stack, mixed $value, string $name) use ($class) {
                return $stack->put($name, $this->resolveArgument($class->getProperty($name), $value, $stack));
            }, new Collection())
            ->pipe(fn (Collection $resolved) => $resolved->transform(function ($value) use ($resolved) {
                if ($value instanceof DeferredAttributeResolver) {
                    return $value->resolve($resolved);
                }

                return $value;
            }))
            ->all();
    }

    private function resolveArgument(\ReflectionProperty $property, mixed $value, Collection $context): mixed
    {
        if (is_null($value)) {
            return $value;
        }

        return PropertyAttributeResolver::resolve($property, $value, $context)
            ?? PropertyTypeResolver::resolve($property, $value);
    }
}
