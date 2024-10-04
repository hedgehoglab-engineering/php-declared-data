<?php

namespace HedgehoglabEngineering\DeclaredData\Attributes;

use HedgehoglabEngineering\DeclaredData\Contracts\ResolvableDataAttributeInterface;
use HedgehoglabEngineering\DeclaredData\Resolvers\DeferredAttributeResolver;
use Attribute;
use Illuminate\Support\Collection;
use Netsells\HashModelIds\ModelIdHasherInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HashedIdOf implements ResolvableDataAttributeInterface
{
    private bool $deferred = false;

    /**
     * @param class-string<\Illuminate\Database\Eloquent\Model>|string $class
     */
    public function __construct(
        private readonly string $class,
        private readonly HashedIdOfType $type = HashedIdOfType::FQCN
    ) {
        //
    }

    public function resolveValue(mixed $value, Collection $context): mixed
    {
        if (! $class = $this->resolveClass($context)) {
            $this->deferred = true;

            return new DeferredAttributeResolver($value, function (string $value, Collection $context) {
                return $this->resolveValue($value, $context);
            });
        }

        return $this->doResolveValue(new $class(), $value);
    }

    private function doResolveValue(object $instance, mixed $value): mixed
    {
        if (is_scalar($value)) {
            return $this->getModelIdHasher()->decode($instance, $value);
        }

        return array_map(fn ($value) => $this->doResolveValue($instance, $value), $value);
    }

    private function resolveClass(Collection $context): ?string
    {
        if ($this->type === HashedIdOfType::FQCN) {
            return $this->class;
        }

        if ((! $class = $this->getClassFromContext($context)) && $this->deferred) {
            throw new \Exception('A morph type must be specified and resolved before its corresponding id!');
        }

        return $class;
    }

    private function getClassFromContext(Collection $context): ?string
    {
        return $context->get($this->class);
    }

    private function getModelIdHasher(): ModelIdHasherInterface
    {
        return app(ModelIdHasherInterface::class);
    }
}
