<?php

namespace HedgehoglabEngineering\DeclaredData\Attributes;

use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableDataAttributeInterface;
use Attribute;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Collection;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeFromFormat implements ResolvableDataAttributeInterface
{
    public function __construct(
        private readonly string $format,
        private readonly DateTimeZone|string|false|null $timezone = null,
        private readonly DateTimeZone|string|false|null $toTimezone = null
    ) {
        //
    }

    public function resolveValue(mixed $value, Collection $context): mixed
    {
        $dateTime = Carbon::createFromFormat($this->format, $value, $this->timezone);

        if (! is_null($this->toTimezone)) {
            $dateTime->setTimezone($this->toTimezone);
        }

        return $dateTime;
    }
}
