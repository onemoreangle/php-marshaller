<?php

namespace OneMoreAngle\Marshaller\Test\Functional\Json;

use OneMoreAngle\Marshaller\Api\Json;
use OneMoreAngle\Marshaller\Exception\UnresolvedTargetTypeException;
use OneMoreAngle\Marshaller\Test\Fixtures\TargetType\CustomData;
use OneMoreAngle\Marshaller\Test\Fixtures\TargetType\PersonData;
use OneMoreAngle\Marshaller\Test\Fixtures\TargetType\UnresolvedPersonData;
use PHPUnit\Framework\TestCase;

class TargetTypeTest extends TestCase
{
    public function testTargetType() {
        $json = '{"customData":{"name":"John Doe","age":30}}';
        $expectedPersonData = new PersonData();
        $expectedCustomData = new CustomData();
        $expectedCustomData->name = "John Doe";
        $expectedCustomData->age = 30;
        $expectedPersonData->customData = $expectedCustomData;

        $deserialized = Json::unmarshal($json, PersonData::class);
        $this->assertEquals($expectedPersonData, $deserialized);
    }

    public function testTargetTypeUnresolved() {
        $json = '{"customData":{"name":"John Doe","age":30}}';
        $this->expectException(UnresolvedTargetTypeException::class);
        Json::unmarshal($json, UnresolvedPersonData::class);
    }
}