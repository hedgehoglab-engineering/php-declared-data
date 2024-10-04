<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Attributes;

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
