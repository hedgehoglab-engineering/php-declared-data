<?php

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use DateTimeInterface;
use HedgehoglabEngineering\LaravelDto\AbstractDeclaredData;
use HedgehoglabEngineering\LaravelDto\Attributes\CollectionOf;
use HedgehoglabEngineering\LaravelDto\Attributes\DateTimeFromFormat;
use HedgehoglabEngineering\LaravelDto\Attributes\HashedIdOf;
use HedgehoglabEngineering\LaravelDto\Attributes\JsonDecode;
use HedgehoglabEngineering\LaravelDto\Attributes\MapArgumentName;
use HedgehoglabEngineering\LaravelDto\Contracts\ResolvableData;
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
