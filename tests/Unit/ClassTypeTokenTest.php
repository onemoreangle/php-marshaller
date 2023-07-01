<?php

namespace OneMoreAngle\Marshaller\Test\Unit;

use OneMoreAngle\Marshaller\Typing\ClassTypeToken;
use PHPUnit\Framework\TestCase;
use stdClass;

class ClassTypeTokenTest extends TestCase {

    public function testCreate() {
        $token = ClassTypeToken::create(stdClass::class);
        $this->assertEquals(stdClass::class, $token->key());
    }

    public function testGetInstanceCache() {
        $token1 = ClassTypeToken::create(stdClass::class);
        $token2 = ClassTypeToken::create(stdClass::class);
        $this->assertSame($token1, $token2);
    }
}