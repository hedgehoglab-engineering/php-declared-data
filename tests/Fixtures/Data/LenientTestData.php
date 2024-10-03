<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\LaravelDataTools\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\LenientData;

class LenientTestData extends AbstractDeclaredData implements LenientData
{
    public function __construct(
        public string $field1,
        public int $field2
    ) {
        //
    }
}
