<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\Tests\Fixtures\Data;

use DateTimeInterface;
use HedgehoglabEngineering\DeclaredData\AbstractDeclaredData;
use HedgehoglabEngineering\DeclaredData\Attributes\CollectionOf;
use HedgehoglabEngineering\DeclaredData\Attributes\DateTimeFromFormat;
use HedgehoglabEngineering\DeclaredData\Attributes\JsonDecode;
use HedgehoglabEngineering\DeclaredData\Attributes\MapArgumentName;
use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableData;
use Illuminate\Support\Collection;

class ResolvableTestData extends AbstractDeclaredData implements ResolvableData
{
    public function __construct(
        #[CollectionOf(class: ResolvableTestNestedData::class)]
        public Collection $nestedTestDatas,
        #[DateTimeFromFormat('d-M-Y H:i:s', 'Europe/London', 'Asia/Tokyo')]
        public DateTimeInterface $date,
        #[JsonDecode(associative: true)]
        public $json,
        #[MapArgumentName(name: 'first_name')]
        public string $firstName,
    ) {
        //
    }
}
