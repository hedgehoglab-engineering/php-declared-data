<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\Tests\Feature;

use HedgehoglabEngineering\Tests\Fixtures\Data\LenientTestData;
use PHPUnit\Framework\TestCase;

class LenientDataTest extends TestCase
{
    public function test_ignores_extra_properties()
    {
        $inputData = [
            'field1' => 'Test String',
            'field2' => 42,
            'extra_field1' => 'Extra Value 1',
            'extra_field2' => 'Extra Value 2',
        ];

        $testData = LenientTestData::create($inputData);

        $this->assertEquals('Test String', $testData->field1);
        $this->assertEquals(42, $testData->field2);

        $this->assertObjectNotHasProperty('extra_field1', $testData);
        $this->assertObjectNotHasProperty('extra_field2', $testData);
    }

    public function test_throws_exception_on_missing_required_properties()
    {
        $this->expectException(\TypeError::class);

        $inputData = [
            'field1' => 'Missing field2',
        ];

        LenientTestData::create($inputData);
    }
}
