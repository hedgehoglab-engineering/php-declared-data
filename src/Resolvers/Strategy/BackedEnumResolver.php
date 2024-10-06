<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Resolvers\Strategy;

class BackedEnumResolver extends AbstractTypeResolver
{
    public static function resolvesType(string $type): bool
    {
        return is_subclass_of($type, \BackedEnum::class);
    }

    public function resolve(mixed $value): mixed
    {
        /** @var \BackedEnum $type */
        $type = $this->type;

        if (! $resolved = $type::tryFrom($value)) {
            throw new TypeResolverException();
        }

        return $resolved;
    }
}
