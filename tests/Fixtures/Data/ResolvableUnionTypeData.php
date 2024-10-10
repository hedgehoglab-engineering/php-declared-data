<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use Carbon\CarbonImmutable;
use HedgehoglabEngineering\DeclaredData\AbstractDeclaredData;
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableData;
use HedgehoglabEngineering\DeclaredData\Contracts\SparseData;

class ResolvableUnionTypeData extends AbstractDeclaredData implements ResolvableData, SparseData
{
    public function __construct(
        public readonly Enum1|Enum2 $state,
        public readonly int|CarbonImmutable $date,
        public readonly LenientTestData|SparseTestData $data,
    ) {
        //
    }
}
