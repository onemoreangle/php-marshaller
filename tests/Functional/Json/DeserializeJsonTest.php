<?php

namespace OneMoreAngle\Marshaller\Test\Functional\Json;

use OneMoreAngle\Marshaller\Api\Json;
use OneMoreAngle\Marshaller\Test\Fixtures\Order;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use PHPUnit\Framework\TestCase;

class DeserializeJsonTest extends TestCase {

    public function testSimpleAssoc() {
        $json = '{"a": 1, "b": 2}';
        $expected = [
            'a' => 1,
            'b' => 2
        ];

        $arr = Json::unmarshal($json, TypeTokenFactory::array());
        $this->assertEquals($expected, $arr);
    }

    public function testSimpleObject() {
        $data = new Order();
        $data->setId(10);
        $data->setName('John Doe');
        $data->setPrice(100.0);
        $data->setPaid(false);
        $data->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.');

        $compare = [
            'id' => 10,
            'name' => 'John Doe',
            'price' => 100.0,
            'paid' => false,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.',
        ];
        $raw = json_encode($compare);
        $object = Json::unmarshal($raw, Order::class);
        $this->assertObjectEquals($data, $object);
    }
}