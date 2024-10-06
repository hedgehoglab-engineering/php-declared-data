<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Resolvers\Strategy;

use App\Support\Data\Contracts\CreatableData;

class CreatableDataResolver extends AbstractTypeResolver
{
    public static function resolvesType(string $type): bool
    {
        return is_a($type, CreatableData::class, true);
    }

    public function resolve(mixed $value): mixed
    {
        /** @var \App\Support\Data\Contracts\CreatableData $type */
        $type = $this->type;

        try {
            $resolved = $type::create($value);
        } catch (\Throwable) {
            throw new TypeResolverException();
        }

        return $resolved;
    }
}
