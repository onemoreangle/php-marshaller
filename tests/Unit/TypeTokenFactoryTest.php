<?php

namespace OneMoreAngle\Marshaller\Test\Unit;

use OneMoreAngle\Marshaller\Exception\UnsupportedValueException;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use PHPUnit\Framework\TestCase;

class TypeTokenFactoryTest extends TestCase {

    public function testTokenizeWithDifferentTypes() {
        $typeToken = TypeTokenFactory::tokenize(123);
        $this->assertEquals('integer', $typeToken->key());

        $typeToken = TypeTokenFactory::tokenize('test');
        $this->assertEquals('string', $typeToken->key());

        $typeToken = TypeTokenFactory::tokenize(new \stdClass());
        $this->assertEquals('stdClass', $typeToken->key());

        $typeToken = TypeTokenFactory::tokenize([]);
        $this->assertEquals('array', $typeToken->key());

        $typeToken = TypeTokenFactory::tokenize(true);
        $this->assertEquals('boolean', $typeToken->key());

        $typeToken = TypeTokenFactory::tokenize(1.23);
        $this->assertEquals('float', $typeToken->key());
    }

    public function testFromType() {
        $typeToken = TypeTokenFactory::fromType('integer');
        $this->assertEquals('integer', $typeToken->key());

        $typeToken = TypeTokenFactory::fromType('string');
        $this->assertEquals('string', $typeToken->key());

        $typeToken = TypeTokenFactory::fromType('array');
        $this->assertEquals('array', $typeToken->key());

        $typeToken = TypeTokenFactory::fromType('boolean');
        $this->assertEquals('boolean', $typeToken->key());

        $typeToken = TypeTokenFactory::fromType('float');
        $this->assertEquals('float', $typeToken->key());

        $this->expectException(UnsupportedValueException::class);
        TypeTokenFactory::fromType('resource');
    }

    public function testFromNamedType() {
        $typeToken = TypeTokenFactory::fromNamedType('int');
        $this->assertEquals('integer', $typeToken->key());

        $typeToken = TypeTokenFactory::fromNamedType('string');
        $this->assertEquals('string', $typeToken->key());

        $typeToken = TypeTokenFactory::fromNamedType('stdClass');
        $this->assertEquals('stdClass', $typeToken->key());

        $typeToken = TypeTokenFactory::fromNamedType('array');
        $this->assertEquals('array', $typeToken->key());

        $this->expectException(UnsupportedValueException::class);
        TypeTokenFactory::fromNamedType('resource');
    }
}