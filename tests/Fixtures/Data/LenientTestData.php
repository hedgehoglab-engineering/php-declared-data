<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\LaravelDto\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDto\Contracts\LenientData;

class LenientTestData extends AbstractDeclaredData implements LenientData
{
    public function __construct(
        public string $field1,
        public int $field2
    ) {
        //
    }
}
