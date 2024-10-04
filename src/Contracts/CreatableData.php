<?php

namespace HedgehoglabEngineering\DeclaredData\Contracts;

interface CreatableData
{
    public static function create(mixed $arguments): self;
}
