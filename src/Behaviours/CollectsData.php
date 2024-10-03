<?php

namespace HedgehoglabEngineering\LaravelDataTools\Behaviours;

use Illuminate\Support\Collection;

trait CollectsData
{
    public static function collect(iterable $items): Collection
    {
        return Collection::make($items)->map(function (mixed $items) {
            return static::create($items);
        });
    }
}
