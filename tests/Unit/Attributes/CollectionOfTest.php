<?php

namespace HedgehoglabEngineering\Tests\Unit\Attributes;

use HedgehoglabEngineering\LaravelDataTools\Attributes\CollectionOf;
use HedgehoglabEngineering\Tests\Fixtures\Enums\TestEnum;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CollectionOfTest extends TestCase
{
    public static function resolveValueData(): array
    {
        return [
            'BackedEnum with strings' => [
                'class' => TestEnum::class,
                'value' => ['foo', 'bar'],
                'expected' => new Collection([TestEnum::Foo, TestEnum::Bar]),
            ],
            'BackedEnum with instances' => [
                'class' => TestEnum::class,
                'value' => [TestEnum::Foo, TestEnum::Bar],
                'expected' => new Collection([TestEnum::Foo, TestEnum::Bar]),
            ],
            'Default case' => [
                'class' => \stdClass::class,
                'value' => [1, 2, 3],
                'expected' => new Collection([1, 2, 3]),
            ],
        ];
    }

    #[DataProvider('resolveValueData')]
    public function test_resolve_value(string $class, mixed $value, Collection $expected)
    {
        $attribute = new CollectionOf($class);
        $context = new Collection();

        $result = $attribute->resolveValue($value, $context);

        $this->assertEquals($expected, $result);
    }
}
