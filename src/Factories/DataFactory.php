<?php

namespace HedgehoglabEngineering\LaravelDataTools\Factories;

use HedgehoglabEngineering\LaravelDataTools\Contracts\LenientData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\ResolvableData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\SparseData;
use HedgehoglabEngineering\LaravelDataTools\Filters\LenientDataFilter;
use HedgehoglabEngineering\LaravelDataTools\Resolvers\ArgumentNameResolver;
use HedgehoglabEngineering\LaravelDataTools\Resolvers\ArgumentResolver;

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
