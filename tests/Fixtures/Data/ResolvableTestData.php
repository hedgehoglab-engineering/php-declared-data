<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use DateTimeInterface;
use HedgehoglabEngineering\LaravelDataTools\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDataTools\Attributes\CollectionOf;
use HedgehoglabEngineering\LaravelDataTools\Attributes\DateTimeFromFormat;
use HedgehoglabEngineering\LaravelDataTools\Attributes\HashedIdOf;
use HedgehoglabEngineering\LaravelDataTools\Attributes\JsonDecode;
use HedgehoglabEngineering\LaravelDataTools\Attributes\MapArgumentName;
use HedgehoglabEngineering\LaravelDataTools\Contracts\ResolvableData;
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
