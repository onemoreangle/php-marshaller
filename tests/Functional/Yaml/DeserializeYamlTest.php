<?php

namespace OneMoreAngle\Marshaller\Test\Functional\Yaml;

use OneMoreAngle\Marshaller\Api\Yaml;
use OneMoreAngle\Marshaller\Test\Fixtures\Order;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class DeserializeYamlTest extends TestCase {

    public function testSimpleAssoc() {
        $yaml = 'a: 1
b: 2';
        $expected = [
            'a' => 1,
            'b' => 2
        ];

        $arr = Yaml::unmarshal($yaml, TypeTokenFactory::array());
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
        $raw = SymfonyYaml::dump($compare);
        $object = Yaml::unmarshal($raw, Order::class);
        $this->assertObjectEquals($data, $object);
    }
}