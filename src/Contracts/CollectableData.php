<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Contracts;

use Illuminate\Support\Collection;

interface CollectableData
{
    public static function collect(iterable $items): Collection;
}
