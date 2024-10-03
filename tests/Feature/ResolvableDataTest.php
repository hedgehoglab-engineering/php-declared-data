<?php

namespace HedgehoglabEngineering\Tests\Feature;

use DateTimeInterface;
use HedgehoglabEngineering\Tests\Fixtures\Data\ResolvableTestData;
use HedgehoglabEngineering\Tests\Fixtures\Data\ResolvableTestNestedData;
use HedgehoglabEngineering\Tests\Fixtures\Models\TestModel;
use Illuminate\Support\Collection;
use Netsells\HashModelIds\ModelIdHasherInterface;
use PHPUnit\Framework\TestCase;

class ResolvableDataTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $modelIdHasher = $this->createMock(ModelIdHasherInterface::class);

        $modelIdHasher->method('decode')
            ->with($this->isInstanceOf(TestModel::class), $this->anything())
            ->willReturnCallback(function ($model, $hash) {
                return str_replace('hashed_', '', $hash);
            });

        app()->instance(ModelIdHasherInterface::class, $modelIdHasher);
    }

    public function test_resolves_values()
    {
        $inputData = [
            'nestedTestDatas' => [
                ['field1' => 'value1', 'field2' => 2],
                ['field1' => 'value2', 'field2' => 3],
            ],
            'date' => '01-Jan-2021 01:03:15',
            'testModelId' => 'hashed_123',
            'json' => '{"key": "value", "number": 42}',
            'first_name' => 'John',
        ];

        $testData = ResolvableTestData::create($inputData);

        $this->assertInstanceOf(Collection::class, $testData->nestedTestDatas);
        $this->assertCount(2, $testData->nestedTestDatas);
        $this->assertInstanceOf(ResolvableTestNestedData::class, $testData->nestedTestDatas->first());
        $this->assertEquals('value1', $testData->nestedTestDatas->first()->field1);
        $this->assertEquals(2, $testData->nestedTestDatas->first()->field2);

        $this->assertInstanceOf(DateTimeInterface::class, $testData->date);
        $this->assertEquals('2021-01-01 10:03:15', $testData->date->format('Y-m-d H:i:s'));
        $this->assertEquals('Asia/Tokyo', $testData->date->getTimezone()->getName());

        $this->assertEquals(123, $testData->testModelId);

        $this->assertIsArray($testData->json);
        $this->assertEquals(['key' => 'value', 'number' => 42], $testData->json);

        $this->assertEquals('John', $testData->firstName);
        $this->assertFalse(isset($testData->first_name));
    }
}
