<?php

namespace HedgehoglabEngineering\LaravelDto\Contracts;

use Illuminate\Support\Collection;

interface CollectableData
{
    public static function collect(iterable $items): Collection;
}
