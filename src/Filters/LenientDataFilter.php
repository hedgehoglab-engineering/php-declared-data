<?php

namespace HedgehoglabEngineering\DeclaredData\Filters;

use Illuminate\Support\Collection;

class LenientDataFilter
{
    public static function filter(string $class, iterable $arguments): array
    {
        return (new self())->filterArguments($class, $arguments);
    }

    private function filterArguments(string $class, iterable $arguments): array
    {
        $class = new \ReflectionClass($class);

        return Collection::make($arguments)->filter(function (mixed $value, string $name) use ($class) {
            return $class->hasProperty($name);
        })->all();
    }
}
