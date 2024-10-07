<?php

namespace HedgehoglabEngineering\Tests\Feature;

use Carbon\CarbonImmutable;
use HedgehoglabEngineering\Tests\Fixtures\Data\Enum2;
use HedgehoglabEngineering\Tests\Fixtures\Data\LenientTestData;
use HedgehoglabEngineering\Tests\Fixtures\Data\ResolvableUnionTypeData;
use HedgehoglabEngineering\Tests\Fixtures\Data\SparseTestData;
use HedgehoglabEngineering\Tests\Fixtures\Data\Enum1;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ResolvableUnionTypeDataTest extends TestCase
{
    public static function resolvableUnionTypeDataProvider(): array
    {
        return [
            'state as StringEnum, date as int, data as LenientTestData' => [
                'inputData' => [
                    'state' => 'Value 1',
                    'date' => 1610000000,
                    'data' => LenientTestData::create([
                        'field1' => 'Test String',
                        'field2' => 42,
                        'extra_field' => 'ignored',
                    ]),
                ],
                'expectedState' => Enum1::VALUE1,
                'expectedDate' => 1610000000,
                'expectedData' => ['field1' => 'Test String', 'field2' => 42],
            ],
            'state as IntEnum, date as CarbonImmutable, data as SparseTestData' => [
                'inputData' => [
                    'state' => 'Value 3',
                    'date' => '2021-01-01',
                    'data' => SparseTestData::create([
                        'field1' => 'Another Test',
                    ]),
                ],
                'expectedState' => Enum2::VALUE3,
                'expectedDate' => new CarbonImmutable('2021-01-01'),
                'expectedData' => ['field1' => 'Another Test'],
            ],
            'state as StringEnum, date as CarbonImmutable, data as LenientTestData' => [
                'inputData' => [
                    'state' => 'Value 2',
                    'date' => '2021-02-01',
                    'data' => LenientTestData::create([
                        'field1' => 'Lenient Data',
                        'field2' => 99,
                    ]),
                ],
                'expectedState' => Enum1::VALUE2,
                'expectedDate' => new CarbonImmutable('2021-02-01'),
                'expectedData' => ['field1' => 'Lenient Data', 'field2' => 99],
            ],
            'state as IntEnum, date as int, data as SparseTestData' => [
                'inputData' => [
                    'state' => 'Value 3',
                    'date' => 1610000000,
                    'data' => SparseTestData::create([
                        'field1' => 'Sparse Data',
                    ]),
                ],
                'expectedState' => Enum2::VALUE3,
                'expectedDate' => 1610000000,
                'expectedData' => ['field1' => 'Sparse Data'],
            ],
        ];
    }

    #[DataProvider('resolvableUnionTypeDataProvider')]
    public function test_resolvable_union_type_data($inputData, $expectedState, $expectedDate, $expectedData)
    {
        $data = ResolvableUnionTypeData::create($inputData);

        $this->assertEquals($expectedState, $data->state);

        if ($expectedDate instanceof CarbonImmutable) {
            $this->assertInstanceOf(CarbonImmutable::class, $data->date);
            $this->assertTrue($expectedDate->eq($data->date));
        } else {
            $this->assertEquals($expectedDate, $data->date);
        }

        $this->assertEquals($expectedData, $data->data->toArray());
    }
}
