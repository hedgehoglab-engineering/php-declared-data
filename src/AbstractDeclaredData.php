<?php

namespace HedgehoglabEngineering\LaravelDto;

use HedgehoglabEngineering\LaravelDto\Behaviours\ArraysData;
use HedgehoglabEngineering\LaravelDto\Behaviours\CollectsData;
use HedgehoglabEngineering\LaravelDto\Behaviours\CreatesData;
use HedgehoglabEngineering\LaravelDto\Behaviours\DeclaresData;
use HedgehoglabEngineering\LaravelDto\Contracts\CollectableData;
use HedgehoglabEngineering\LaravelDto\Contracts\CreatableData;
use Illuminate\Contracts\Support\Arrayable;

abstract class AbstractDeclaredData implements Arrayable, CollectableData, CreatableData
{
    use ArraysData;
    use CollectsData;
    use CreatesData;
    use DeclaresData;
}
