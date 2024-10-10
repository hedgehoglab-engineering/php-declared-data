<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData;

use HedgehoglabEngineering\DeclaredData\Behaviours\ArraysData;
use HedgehoglabEngineering\DeclaredData\Behaviours\CollectsData;
use HedgehoglabEngineering\DeclaredData\Behaviours\CreatesData;
use HedgehoglabEngineering\DeclaredData\Behaviours\DeclaresData;
use HedgehoglabEngineering\DeclaredData\Contracts\CollectableData;
use HedgehoglabEngineering\DeclaredData\Contracts\CreatableData;
use Illuminate\Contracts\Support\Arrayable;

abstract class AbstractDeclaredData implements Arrayable, CollectableData, CreatableData
{
    use ArraysData;
    use CollectsData;
    use CreatesData;
    use DeclaresData;
}
