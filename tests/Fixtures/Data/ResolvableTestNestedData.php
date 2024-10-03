<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\LaravelDto\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDto\Contracts\ResolvableData;

class ResolvableTestNestedData extends AbstractDeclaredData implements ResolvableData
{
    public function __construct(
        public string $field1,
        public int $field2
    ) {
        //
    }
}
