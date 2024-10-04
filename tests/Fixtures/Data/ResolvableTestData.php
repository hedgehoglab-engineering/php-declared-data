<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use DateTimeInterface;
use HedgehoglabEngineering\DeclaredData\AbstractDeclaredData;
use HedgehoglabEngineering\DeclaredData\Attributes\CollectionOf;
use HedgehoglabEngineering\DeclaredData\Attributes\DateTimeFromFormat;
use HedgehoglabEngineering\DeclaredData\Attributes\HashedIdOf;
use HedgehoglabEngineering\DeclaredData\Attributes\JsonDecode;
use HedgehoglabEngineering\DeclaredData\Attributes\MapArgumentName;
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableData;
use HedgehoglabEngineering\Tests\Fixtures\Models\TestModel;
use Illuminate\Support\Collection;

class ResolvableTestData extends AbstractDeclaredData implements ResolvableData
{
    public function __construct(
        #[CollectionOf(class: ResolvableTestNestedData::class)]
        public Collection $nestedTestDatas,
        #[DateTimeFromFormat('d-M-Y H:i:s', 'Europe/London', 'Asia/Tokyo')]
        public DateTimeInterface $date,
        #[HashedIdOf(TestModel::class)]
        public string $testModelId,
        #[JsonDecode(associative: true)]
        public $json,
        #[MapArgumentName(name: 'first_name')]
        public string $firstName,
    ) {
        //
    }
}
