<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\LaravelDataTools\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDataTools\Contracts\SparseData;

class SparseTestData extends AbstractDeclaredData implements SparseData
{
    public function __construct(
        public string $field1,
        public int $field2
    ) {
        //
    }
}
