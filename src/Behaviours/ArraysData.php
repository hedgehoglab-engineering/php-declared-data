<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Behaviours;

use Illuminate\Support\Collection;

trait ArraysData
{
    public function toArray(): array
    {
        return Collection::make(get_object_vars($this))->toArray();
    }
}
