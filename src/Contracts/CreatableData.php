<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Contracts;

interface CreatableData
{
    public static function create(mixed $arguments): self;
}
