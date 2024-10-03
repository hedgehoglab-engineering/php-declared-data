<?php

namespace HedgehoglabEngineering\LaravelDataTools\Behaviours;

use HedgehoglabEngineering\LaravelDataTools\Factories\DataFactory;

trait CreatesData
{
    public static function create(mixed $arguments): static
    {
        return DataFactory::create(static::class, $arguments);
    }
}
