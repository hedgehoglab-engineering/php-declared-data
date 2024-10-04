<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\DeclaredData\AbstractDeclaredData;
use HedgehoglabEngineering\DeclaredData\Attributes\MapArgumentName;
use HedgehoglabEngineering\DeclaredData\Behaviours\FromValidatedData;
use HedgehoglabEngineering\DeclaredData\Contracts\LenientData;
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableData;
use HedgehoglabEngineering\DeclaredData\Contracts\SparseData;

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
