<?php

namespace OneMoreAngle\Marshaller\Test\Unit;

use OneMoreAngle\Marshaller\Typing\ArrayTypeToken;
use PHPUnit\Framework\TestCase;

class ArrayTypeTokenTest extends TestCase {

    public function testCreate() {
        $token = ArrayTypeToken::create();
        $this->assertEquals('array', $token->key());
    }

    public function testGetInstanceCache() {
        $token1 = ArrayTypeToken::create();
        $token2 = ArrayTypeToken::create();
        $this->assertSame($token1, $token2);
    }
}