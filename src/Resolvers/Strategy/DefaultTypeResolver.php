<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Resolvers\Strategy;

class DefaultTypeResolver extends AbstractTypeResolver
{
    public static function resolvesType(string $type): bool
    {
        return true;
    }

    public function resolve(mixed $value): mixed
    {
        return $value;
    }
}
