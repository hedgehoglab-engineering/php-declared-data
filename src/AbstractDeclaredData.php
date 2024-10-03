<?php

namespace HedgehoglabEngineering\LaravelDataTools;

use HedgehoglabEngineering\LaravelDataTools\Behaviours\ArraysData;
use HedgehoglabEngineering\LaravelDataTools\Behaviours\CollectsData;
use HedgehoglabEngineering\LaravelDataTools\Behaviours\CreatesData;
use HedgehoglabEngineering\LaravelDataTools\Behaviours\DeclaresData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\CollectableData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\CreatableData;
use Illuminate\Contracts\Support\Arrayable;

abstract class AbstractDeclaredData implements Arrayable, CollectableData, CreatableData
{
    use ArraysData;
    use CollectsData;
    use CreatesData;
    use DeclaresData;
}
