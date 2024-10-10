<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\Tests\Feature;

use HedgehoglabEngineering\Tests\Fixtures\Data\SparseTestData;
use PHPUnit\Framework\TestCase;

class SparseDataTest extends TestCase
{
    public function test_sparse_test_data_with_missing_properties()
    {
        $inputData = [
            'field1' => 'Partial Data',
        ];

        $testData = SparseTestData::create($inputData);

        $this->assertEquals('Partial Data', $testData->field1);

        $this->assertFalse(isset($testData->field2));
    }

    public function test_sparse_test_data_with_no_properties()
    {
        $inputData = [];

        $testData = SparseTestData::create($inputData);

        $this->assertFalse(isset($testData->field1));
        $this->assertFalse(isset($testData->field2));
    }

    public function test_sparse_test_data_throws_exception_on_extra_properties()
    {
        $this->expectException(\ReflectionException::class);

        $inputData = [
            'field1' => 'Test',
            'field2' => 42,
            'extra_field' => 'Should not be accepted',
        ];

        SparseTestData::create($inputData);
    }
}
