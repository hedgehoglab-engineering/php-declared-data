<?php

namespace HedgehoglabEngineering\LaravelDataTools\Contracts;

interface CreatableData
{
    public static function create(mixed $arguments): self;
}
