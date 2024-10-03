<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\LaravelDataTools\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\ResolvableData;

class ResolvableTestNestedData extends AbstractDeclaredData implements ResolvableData
{
    public function __construct(
        public string $field1,
        public int $field2
    ) {
        //
    }
}
