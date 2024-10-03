<?php

namespace HedgehoglabEngineering\LaravelDto\Behaviours;

use HedgehoglabEngineering\LaravelDto\Factories\DataFactory;

trait CreatesData
{
    public static function create(mixed $arguments): static
    {
        return DataFactory::create(static::class, $arguments);
    }
}
