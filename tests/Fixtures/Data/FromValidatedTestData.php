<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\LaravelDto\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDto\Attributes\MapArgumentName;
use HedgehoglabEngineering\LaravelDto\Behaviours\FromValidatedData;
use HedgehoglabEngineering\LaravelDto\Contracts\LenientData;
use HedgehoglabEngineering\LaravelDto\Contracts\ResolvableData;
use HedgehoglabEngineering\LaravelDto\Contracts\SparseData;

class FromValidatedTestData extends AbstractDeclaredData implements ResolvableData, LenientData, SparseData
{
    use FromValidatedData;

    public function __construct(
        #[MapArgumentName(name: 'first_name')]
        public string $firstName,
        public int $age,
    ) {
        //
    }
}
