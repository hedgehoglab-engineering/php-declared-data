<?php

namespace HedgehoglabEngineering\DeclaredData\Factories;

use HedgehoglabEngineering\DeclaredData\Contracts\LenientData;
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableData;
use HedgehoglabEngineering\DeclaredData\Contracts\SparseData;
use HedgehoglabEngineering\DeclaredData\Filters\LenientDataFilter;
use HedgehoglabEngineering\DeclaredData\Resolvers\ArgumentNameResolver;
use HedgehoglabEngineering\DeclaredData\Resolvers\ArgumentResolver;

class DataFactory
{
    public static function create(string $class, mixed $arguments)
    {
        if ($arguments instanceof $class) {
            return $arguments;
        }

        if (is_iterable($arguments)) {
            return self::fromIterable($class, $arguments);
        }

        return new $class($arguments);
    }

    private static function fromIterable(string $class, iterable $arguments)
    {
        $arguments = ArgumentNameResolver::resolve(class: $class, arguments: $arguments);

        if (is_a($class, LenientData::class, true)) {
            $arguments = LenientDataFilter::filter($class, $arguments);
        }

        if (is_a($class, ResolvableData::class, true)) {
            $arguments = ArgumentResolver::resolve($class, $arguments);
        }

        if (is_a($class, SparseData::class, true)) {
            return SparseDataFactory::create($class, $arguments);
        }

        return new $class(...$arguments);
    }
}
