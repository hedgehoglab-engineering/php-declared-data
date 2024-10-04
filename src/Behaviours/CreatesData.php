<?php

namespace HedgehoglabEngineering\DeclaredData\Behaviours;

use HedgehoglabEngineering\DeclaredData\Factories\DataFactory;

trait CreatesData
{
    public static function create(mixed $arguments): static
    {
        return DataFactory::create(static::class, $arguments);
    }
}
