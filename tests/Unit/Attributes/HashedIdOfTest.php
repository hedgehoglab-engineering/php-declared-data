<?php

namespace HedgehoglabEngineering\Tests\Unit\Attributes;

use HedgehoglabEngineering\DeclaredData\Attributes\HashedIdOf;
use HedgehoglabEngineering\DeclaredData\Attributes\HashedIdOfType;
use HedgehoglabEngineering\DeclaredData\Resolvers\DeferredAttributeResolver;
use HedgehoglabEngineering\Tests\Fixtures\Models\TestModel;
use Illuminate\Support\Collection;
use Netsells\HashModelIds\ModelIdHasherInterface;
use PHPUnit\Framework\TestCase;

class HashedIdOfTest extends TestCase
{
    private ModelIdHasherInterface $modelIdHasher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modelIdHasher = $this->createMock(ModelIdHasherInterface::class);

        app()->instance(ModelIdHasherInterface::class, $this->modelIdHasher);
    }

    public function test_hashed_id_of_resolves_hashed_id()
    {
        $hashedId = 'hashed_1';

        $this->modelIdHasher->expects($this->once())
            ->method('decode')
            ->with($this->isInstanceOf(TestModel::class), $hashedId)
            ->willReturn('1');

        $attribute = new HashedIdOf(TestModel::class, HashedIdOfType::FQCN);

        $context = new Collection();

        $result = $attribute->resolveValue($hashedId, $context);

        $this->assertEquals(1, $result);
    }

    public function test_hashed_id_of_resolves_array_of_hashed_ids()
    {
        $hashedIds = ['hashed_1', 'hashed_2', 'hashed_3'];
        $decodedIds = ['1', '2', '3'];

        $this->modelIdHasher->method('decode')
            ->with($this->isInstanceOf(TestModel::class), $this->anything())
            ->willReturnCallback(function ($model, $hash) {
                return str_replace('hashed_', '', $hash);
            });

        $attribute = new HashedIdOf(TestModel::class, HashedIdOfType::FQCN);

        $context = new Collection();

        $result = $attribute->resolveValue($hashedIds, $context);

        $this->assertEquals($decodedIds, $result);
    }

    public function test_hashed_id_of_with_morph_type_and_deferred_resolution()
    {
        $context = new Collection();

        $hashedId = 'hashed_1';

        $attribute = new HashedIdOf('type', HashedIdOfType::MORPH);

        $result = $attribute->resolveValue($hashedId, $context);

        $this->assertInstanceOf(DeferredAttributeResolver::class, $result);

        $context->put('type', TestModel::class);

        $this->modelIdHasher->expects($this->once())
            ->method('decode')
            ->with($this->isInstanceOf(TestModel::class), $hashedId)
            ->willReturn('1');

        $resolvedValue = $result->resolve($context);

        $this->assertEquals(1, $resolvedValue);
    }

    public function test_hashed_id_of_with_morph_type_and_missing_class_throws_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('A morph type must be specified and resolved before its corresponding id!');

        $context = new Collection();

        $hashedId = 'hashed_1';

        $attribute = new HashedIdOf('type', HashedIdOfType::MORPH);

        $result = $attribute->resolveValue($hashedId, $context);

        $result->resolve($context);
    }
}
