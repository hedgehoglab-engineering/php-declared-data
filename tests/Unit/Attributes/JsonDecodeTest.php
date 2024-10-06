<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\Tests\Unit\Attributes;

use HedgehoglabEngineering\DeclaredData\Attributes\JsonDecode;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class JsonDecodeTest extends TestCase
{
    public static function resolveValueData(): array
    {
        return     [
            'Valid JSON string to object' => [
                'value' => '{"name": "John", "age": 30}',
                'associative' => false,
                'depth' => 512,
                'flags' => 0,
                'expected' => (object)['name' => 'John', 'age' => 30],
                'expectException' => false,
            ],
            'Valid JSON string to associative array' => [
                'value' => '{"name": "John", "age": 30}',
                'associative' => true,
                'depth' => 512,
                'flags' => 0,
                'expected' => ['name' => 'John', 'age' => 30],
                'expectException' => false,
            ],
            'Null associative (default)' => [
                'value' => '{"name": "John", "age": 30}',
                'associative' => null,
                'depth' => 512,
                'flags' => 0,
                'expected' => (object)['name' => 'John', 'age' => 30],
                'expectException' => false,
            ],
            'Invalid JSON string' => [
                'value' => '{"name": "John", "age": 30',
                'associative' => true,
                'depth' => 512,
                'flags' => JSON_THROW_ON_ERROR,
                'expected' => null,
                'expectException' => true,
            ],
            'Invalid UTF-8 sequence' => [
                'value' => "\xB1\x31",
                'associative' => true,
                'depth' => 512,
                'flags' => JSON_THROW_ON_ERROR,
                'expected' => null,
                'expectException' => true,
            ],
            'Valid JSON with depth limit exceeded' => [
                'value' => '{"a":{"b":{"c":{"d":"e"}}}}',
                'associative' => true,
                'depth' => 3,
                'flags' => JSON_THROW_ON_ERROR,
                'expected' => null,
                'expectException' => true,
            ],
            'Valid JSON within depth limit' => [
                'value' => '{"a":{"b":{"c":{"d":"e"}}}}',
                'associative' => true,
                'depth' => 5,
                'flags' => 0,
                'expected' => ['a' => ['b' => ['c' => ['d' => 'e']]]],
                'expectException' => false,
            ],
            'JSON with big integer as string' => [
                'value' => '{"bigInt": 9223372036854775807}',
                'associative' => true,
                'depth' => 512,
                'flags' => JSON_BIGINT_AS_STRING,
                'expected' => ['bigInt' => '9223372036854775807'],
                'expectException' => false,
            ],
            'JSON with comments (invalid JSON)' => [
                'value' => '{/* comment */ "key": "value"}',
                'associative' => true,
                'depth' => 512,
                'flags' => JSON_THROW_ON_ERROR,
                'expected' => null,
                'expectException' => true,
            ],
        ];
    }

    #[DataProvider('resolveValueData')]
    public function test_resolve_value(
        mixed $value,
        ?bool $associative,
        int $depth,
        int $flags,
        mixed $expected,
        bool $expectException
    ) {
        if ($expectException) {
            $this->expectException(\JsonException::class);
        }

        $attribute = new JsonDecode($associative, $depth, $flags);
        $context = new Collection();

        $result = $attribute->resolveValue($value, $context);

        if (!$expectException) {
            $this->assertEquals($expected, $result);
        }
    }
}
