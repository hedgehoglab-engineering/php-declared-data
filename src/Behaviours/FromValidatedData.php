<?php

namespace HedgehoglabEngineering\LaravelDataTools\Behaviours;

use HedgehoglabEngineering\LaravelDataTools\Contracts\CreatableData;
use Illuminate\Support\ValidatedInput;

trait FromValidatedData
{
    public static function fromValidatedData(ValidatedInput $data): self
    {
        if (is_a(static::class, CreatableData::class, true)) {
            return self::create($data);
        }

        return new self(...$data);
    }
}
