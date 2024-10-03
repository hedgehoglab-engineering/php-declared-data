<?php

namespace HedgehoglabEngineering\Tests\Feature;

use HedgehoglabEngineering\Tests\Fixtures\Data\FromValidatedTestData;
use Illuminate\Support\ValidatedInput;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FromValidatedDataTest extends TestCase
{
    public static function fromValidatedData(): array
    {
        return [
            'all properties provided' => [
                'inputData' => [
                    'first_name' => 'John',
                    'age' => 30,
                ],
                'expectedFirstName' => 'John',
                'expectedAge' => 30,
                'expectException' => false,
            ],
            'all properties with extra properties' => [
                'inputData' => [
                    'first_name' => 'Jane',
                    'age' => 25,
                    'extra_field' => 'Extra Value',
                ],
                'expectedFirstName' => 'Jane',
                'expectedAge' => 25,
                'expectException' => false,
            ],
            'missing first_name' => [
                'inputData' => [
                    'age' => 40,
                ],
                'expectedFirstName' => null,
                'expectedAge' => 40,
                'expectException' => false,
            ],
            'missing age' => [
                'inputData' => [
                    'first_name' => 'Alice',
                ],
                'expectedFirstName' => 'Alice',
                'expectedAge' => null,
                'expectException' => false,
            ],
            'no properties provided' => [
                'inputData' => [],
                'expectedFirstName' => null,
                'expectedAge' => null,
                'expectException' => false,
            ],
            'missing properties with extra properties' => [
                'inputData' => [
                    'extra_field' => 'Extra Value',
                ],
                'expectedFirstName' => null,
                'expectedAge' => null,
                'expectException' => false,
            ],
        ];
    }

    #[DataProvider('fromValidatedData')]
    public function test_from_validated_data(
        array $inputData,
        ?string $expectedFirstName,
        ?int $expectedAge,
        bool $expectException
    ) {
        if ($expectException) {
            $this->expectException(\TypeError::class);
        }

        $data = FromValidatedTestData::fromValidatedData(new ValidatedInput($inputData));

        if (!$expectException) {
            $this->assertEquals($expectedFirstName, $data->firstName ?? null);
            $this->assertEquals($expectedAge, $data->age ?? null);
        }
    }
}
