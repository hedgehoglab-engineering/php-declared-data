<?php

namespace HedgehoglabEngineering\DeclaredData\Resolvers\Strategy;

class DateTimeResolver extends AbstractTypeResolver
{
    public static function resolvesType(string $type): bool
    {
        return is_a($type, \DateTimeInterface::class, true);
    }

    public function resolve(mixed $value): mixed
    {
        try {
            $value = \Carbon\Carbon::parse($value);
        } catch (\Throwable) {
            throw new TypeResolverException();
        }

        return $this->resolveDateTime($value);
    }

    private function resolveDateTime(\Carbon\Carbon $value): \DateTimeInterface
    {
        return match (true) {
            is_a($this->type, \Carbon\CarbonImmutable::class, true) => $value->toImmutable(),
            is_a($this->type, \Carbon\CarbonInterface::class, true) => $value,
            is_a($this->type, \DateTimeImmutable::class, true) => $value->toDateTimeImmutable(),
            default => $value->toDateTime(),
        };
    }
}
