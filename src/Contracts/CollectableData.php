<?php

namespace HedgehoglabEngineering\LaravelDataTools\Contracts;

use Illuminate\Support\Collection;

interface CollectableData
{
    public static function collect(iterable $items): Collection;
}
