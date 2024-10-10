<?php

declare(strict_types=1);

namespace HedgehoglabEngineering\DeclaredData\Behaviours;

use HedgehoglabEngineering\DeclaredData\Factories\SparseDataFactory;

trait DeclaresData
{
    public function has(string $name): bool
    {
        return array_key_exists($name, get_object_vars($this));
    }

    public function missing(string $name): bool
    {
        return ! $this->has($name);
    }

    public function only(string ...$only): static
    {
        $arguments = array_reduce($only, function (array $stack, string $name) {
            if ($this->has($name)) {
                $stack[$name] = $this->{$name};
            }

            return $stack;
        }, []);

        return SparseDataFactory::create(static::class, $arguments);
    }

    public function except(string ...$except): static
    {
        $only = array_diff_key(get_object_vars($this), array_flip($except));

        return $this->only(...array_keys($only));
    }
}
