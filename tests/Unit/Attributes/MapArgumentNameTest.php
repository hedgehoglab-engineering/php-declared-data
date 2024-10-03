<?php

namespace HedgehoglabEngineering\Tests\Unit\Attributes;

use HedgehoglabEngineering\LaravelDto\Attributes\MapArgumentName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MapArgumentNameTest extends TestCase
{
    public static function resolveValueData(): array
    {
        return [
            'Simple name' => ['name' => 'username'],
            'Empty name' => ['name' => ''],
            'Numeric name' => ['name' => '123'],
            'Special characters' => ['name' => '!@#$%^&*()'],
            'Unicode characters' => ['name' => '名前'],
            'Whitespace' => ['name' => '   '],
            'Long string' => ['name' => str_repeat('a', 1000)],
        ];
    }

    #[DataProvider('resolveValueData')]
    public function test_resolve_value(string $name)
    {
        $attribute = new MapArgumentName($name);

        $result = $attribute->resolveValue();

        $this->assertEquals($name, $result);
    }
}
