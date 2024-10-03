<?php

namespace HedgehoglabEngineering\LaravelDto\Factories;

use HedgehoglabEngineering\LaravelDto\Contracts\LenientData;
use HedgehoglabEngineering\LaravelDto\Contracts\ResolvableData;
use HedgehoglabEngineering\LaravelDto\Contracts\SparseData;
use HedgehoglabEngineering\LaravelDto\Filters\LenientDataFilter;
use HedgehoglabEngineering\LaravelDto\Resolvers\ArgumentNameResolver;
use HedgehoglabEngineering\LaravelDto\Resolvers\ArgumentResolver;

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
