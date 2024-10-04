<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\DeclaredData\AbstractDeclaredData;
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableData;

class ResolvableTestNestedData extends AbstractDeclaredData implements ResolvableData
{
    public function __construct(
        public string $field1,
        public int $field2
    ) {
        //
    }
}
