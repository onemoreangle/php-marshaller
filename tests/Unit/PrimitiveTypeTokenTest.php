<?php

namespace OneMoreAngle\Marshaller\Test\Unit;

use OneMoreAngle\Marshaller\Typing\PrimitiveTypeToken;
use PHPUnit\Framework\TestCase;

class PrimitiveTypeTokenTest extends TestCase {

    public function testCreate() {
        $token = PrimitiveTypeToken::create('integer');
        $this->assertEquals('integer', $token->key());
    }

    public function testGetInstanceCache() {
        $token1 = PrimitiveTypeToken::create('integer');
        $token2 = PrimitiveTypeToken::create('integer');
        $this->assertSame($token1, $token2);
    }
}