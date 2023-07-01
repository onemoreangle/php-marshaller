<?php

namespace OneMoreAngle\Marshaller\Test\Unit;

use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use PHPUnit\Framework\TestCase;

class TypeTokenFactoryTest extends TestCase {

    public function testTokenizeWithDifferentTypes() {
        // Test with integer
        $typeToken = TypeTokenFactory::tokenize(123);
        $this->assertEquals('integer', $typeToken->key());

        // Test with string
        $typeToken = TypeTokenFactory::tokenize('test');
        $this->assertEquals('string', $typeToken->key());

        // Test with object
        $typeToken = TypeTokenFactory::tokenize(new \stdClass());
        $this->assertEquals('stdClass', $typeToken->key());

        // Test with array
        $typeToken = TypeTokenFactory::tokenize([]);
        $this->assertEquals('array', $typeToken->key());

        // Test with boolean
        $typeToken = TypeTokenFactory::tokenize(true);
        $this->assertEquals('boolean', $typeToken->key());

        // Test with float
        $typeToken = TypeTokenFactory::tokenize(1.23);
        $this->assertEquals('float', $typeToken->key());
    }

    public function testFromType() {
        // Test with integer
        $typeToken = TypeTokenFactory::fromType('integer');
        $this->assertEquals('integer', $typeToken->key());

        // Test with string
        $typeToken = TypeTokenFactory::fromType('string');
        $this->assertEquals('string', $typeToken->key());

        // Test with array
        $typeToken = TypeTokenFactory::fromType('array');
        $this->assertEquals('array', $typeToken->key());

        // Test with boolean
        $typeToken = TypeTokenFactory::fromType('boolean');
        $this->assertEquals('boolean', $typeToken->key());

        // Test with float
        $typeToken = TypeTokenFactory::fromType('double'); // Note: float becomes 'double' in PHP's gettype()
        $this->assertEquals('float', $typeToken->key());

        // Test with unsupported type
        $this->expectException(\OneMoreAngle\Marshaller\Exception\UnsupportedValueException::class);
        TypeTokenFactory::fromType('resource');
    }

    public function testFromNamedType() {
        // Test with int
        $typeToken = TypeTokenFactory::fromNamedType('int');
        $this->assertEquals('integer', $typeToken->key());

        // Test with string
        $typeToken = TypeTokenFactory::fromNamedType('string');
        $this->assertEquals('string', $typeToken->key());

        // Test with stdClass
        $typeToken = TypeTokenFactory::fromNamedType('stdClass');
        $this->assertEquals('stdClass', $typeToken->key());

        // Test with array
        $typeToken = TypeTokenFactory::fromNamedType('array');
        $this->assertEquals('array', $typeToken->key());

        // Test with unsupported type
        $this->expectException(\OneMoreAngle\Marshaller\Exception\UnsupportedValueException::class);
        TypeTokenFactory::fromNamedType('resource');
    }
}