<?php

namespace HedgehoglabEngineering\LaravelDto\Factories;

class SparseDataFactory
{
    private object $instance;

    public static function create(string $class, iterable $arguments)
    {
        return (new self($class))->withProperties($arguments);
    }

    private function __construct(string $class)
    {
        $this->instance = (new \ReflectionClass($class))->newInstanceWithoutConstructor();
    }

    private function withProperties(iterable $arguments)
    {
        foreach ($arguments as $name => $value) {
            (new \ReflectionProperty($this->instance, $name))->setValue($this->instance, $value);
        }

        return $this->instance;
    }
}
