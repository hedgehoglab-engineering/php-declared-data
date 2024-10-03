<?php

namespace HedgehoglabEngineering\Tests\Unit\Attributes;

use Carbon\Carbon;
use DateTimeZone;
use HedgehoglabEngineering\LaravelDataTools\Attributes\DateTimeFromFormat;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DateTimeFromFormatTest extends TestCase
{
    public static function resolveValueData(): array
    {
        return [
            'Default timezone' => [
                'format' => 'Y-m-d H:i:s',
                'timezone' => null,
                'toTimezone' => null,
                'value' => '2023-10-01 12:00:00',
                'expected' => '2023-10-01 12:00:00',
                'expectException' => false,
            ],
            'With timezone' => [
                'format' => 'Y-m-d H:i:s',
                'timezone' => 'UTC',
                'toTimezone' => null,
                'value' => '2023-10-01 12:00:00',
                'expected' => '2023-10-01 12:00:00',
                'expectException' => false,
            ],
            'With toTimezone' => [
                'format' => 'Y-m-d H:i:s',
                'timezone' => 'UTC',
                'toTimezone' => 'America/New_York',
                'value' => '2023-10-01 12:00:00',
                'expected' => '2023-10-01 08:00:00',
                'expectException' => false,
            ],
            'Different format' => [
                'format' => 'd/m/Y H:i',
                'timezone' => null,
                'toTimezone' => null,
                'value' => '01/10/2023 12:00',
                'expected' => '2023-10-01 12:00:00',
                'expectException' => false,
            ],
            'Timezone objects' => [
                'format' => 'Y-m-d H:i:s',
                'timezone' => new \DateTimeZone('UTC'),
                'toTimezone' => new \DateTimeZone('Asia/Tokyo'),
                'value' => '2023-10-01 12:00:00',
                'expected' => '2023-10-01 21:00:00',
                'expectException' => false,
            ],
            'Invalid format' => [
                'format' => 'sfaek45',
                'timezone' => null,
                'toTimezone' => null,
                'value' => '2023-10-01 12:00:00',
                'expected' => null,
                'expectException' => true,
            ],
            'Invalid date' => [
                'format' => 'Y-m-d',
                'timezone' => null,
                'toTimezone' => null,
                'value' => '22023-023012',
                'expected' => null,
                'expectException' => true,
            ],
        ];
    }

    #[DataProvider('resolveValueData')]
    public function test_resolve_value(
        string $format,
        DateTimeZone|string|false|null $timezone,
        DateTimeZone|string|false|null $toTimezone,
        mixed $value,
        ?string $expected,
        bool $expectException
    ) {
        if ($expectException) {
            $this->expectException(\Exception::class);
        }

        $attribute = new DateTimeFromFormat($format, $timezone, $toTimezone);
        $context = new Collection();

        $result = $attribute->resolveValue($value, $context);

        if (!$expectException) {
            $this->assertInstanceOf(Carbon::class, $result);
            $this->assertEquals($expected, $result->format('Y-m-d H:i:s'));

            $expectedTimezone = $toTimezone ?? $timezone;
            if ($expectedTimezone) {
                $expectedTimezoneName = $expectedTimezone instanceof \DateTimeZone
                    ? $expectedTimezone->getName()
                    : $expectedTimezone;
                $this->assertEquals($expectedTimezoneName, $result->getTimezone()->getName());
            }
        }
    }
}
