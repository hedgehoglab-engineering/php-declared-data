<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use HedgehoglabEngineering\DeclaredData\AbstractDeclaredData;
use HedgehoglabEngineering\DeclaredData\Contracts\LenientData;

class LenientTestData extends AbstractDeclaredData implements LenientData
{
    public function __construct(
        public string $field1,
        public int $field2
    ) {
        //
    }
}
