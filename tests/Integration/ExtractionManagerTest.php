<?php

namespace OneMoreAngle\Marshaller\Test\Integration;

use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Test\Fixtures\Circular\Bar;
use OneMoreAngle\Marshaller\Test\Fixtures\Circular\Foo;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use PHPUnit\Framework\TestCase;

class ExtractionManagerTest extends TestCase {

    public function testCircularReference() {
        $foo = new Foo();
        $foo->bar = new Bar();
        $foo->bar->foo = $foo;

        $this->expectException(CircularReferenceException::class);

        $extractor = new ExtractionManager();
        $extractor->extract($foo);
    }
    public function testCircularReferenceInArray() {
        $foo = new Foo();
        $foo->bar = new Bar();
        $foo->bar->foo = $foo;
        $data = [
            'foo' => $foo,
        ];

        $this->expectException(CircularReferenceException::class);

        $extractor = new ExtractionManager();
        $extractor->extract($data);
    }
}