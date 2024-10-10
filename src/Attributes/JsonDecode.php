<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Attributes;

use Attribute;
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableDataAttributeInterface;
use Illuminate\Support\Collection;

#[Attribute(Attribute::TARGET_PROPERTY)]
class JsonDecode implements ResolvableDataAttributeInterface
{
    public function __construct(
        private readonly ?bool $associative = null,
        private readonly int $depth = 512,
        private readonly int $flags = 0
    ) {
        //
    }

    public function resolveValue(mixed $value, Collection $context): mixed
    {
        return json_decode($value, $this->associative, $this->depth, $this->flags);
    }
}
