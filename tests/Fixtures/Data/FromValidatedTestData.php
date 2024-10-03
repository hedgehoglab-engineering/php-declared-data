<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\LaravelDataTools\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDataTools\Attributes\MapArgumentName;
use HedgehoglabEngineering\LaravelDataTools\Behaviours\FromValidatedData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\LenientData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\ResolvableData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\SparseData;

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
