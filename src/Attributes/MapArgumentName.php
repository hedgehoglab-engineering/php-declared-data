<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\LaravelDataTools\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class MapArgumentName
{
    public function __construct(
        public string $name,
    ) {
    }

    public function resolveValue(): string
    {
        return $this->name;
    }
}
