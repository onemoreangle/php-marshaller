<?php

namespace OneMoreAngle\Marshaller\Test\Integration;

use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Serialization\SerializationManager;
use OneMoreAngle\Marshaller\Test\Fixtures\Circular\Bar;
use OneMoreAngle\Marshaller\Test\Fixtures\Circular\Foo;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use PHPUnit\Framework\TestCase;

class MarshallerTest extends TestCase {

    public function testCircularReference() {
        $foo = new Foo();
        $foo->bar = new Bar();
        $foo->bar->foo = $foo;

        $this->expectException(CircularReferenceException::class);

        $serializationManager = new SerializationManager();
        $serializer = $serializationManager->create(TypeTokenFactory::tokenize($foo));
        $serializer->serialize($foo);
    }
}