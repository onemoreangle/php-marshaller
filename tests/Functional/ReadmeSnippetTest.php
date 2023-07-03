<?php

namespace OneMoreAngle\Marshaller\Test\Functional;

use OneMoreAngle\Marshaller\Api\Json;
use OneMoreAngle\Marshaller\Test\Fixtures\ReadmeCustomClass;
use PHPUnit\Framework\TestCase;

class ReadmeSnippetTest extends TestCase {
    public function testSerialization()
    {
        $data = new ReadmeCustomClass();
        $data->property = 'test';
        $data->property2 = 'test2';
        $serialized = Json::marshal($data);

        $expectedSerialized = '{"custom_name":"test"}';

        $this->assertEquals($expectedSerialized, $serialized);
    }

    public function testDeserialization()
    {
        $json = '{"alias2":"hello"}';
        $expectedDeserialized = new ReadmeCustomClass();
        $expectedDeserialized->property = 'hello';


        $deserialized = Json::unmarshal($json, ReadmeCustomClass::class);
        $this->assertEquals($expectedDeserialized, $deserialized);
    }
}
