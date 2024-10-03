<?php

namespace HedgehoglabEngineering\LaravelDto\Contracts;

interface CreatableData
{
    public static function create(mixed $arguments): self;
}
