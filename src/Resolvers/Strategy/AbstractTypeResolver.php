<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Resolvers\Strategy;

abstract class AbstractTypeResolver
{
    abstract public static function resolvesType(string $type): bool;

    public function __construct(protected readonly string $type)
    {
        //
    }

    /**
     * @throws TypeResolverException
     */
    abstract public function resolve(mixed $value): mixed;
}
