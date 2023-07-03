<?php

namespace OneMoreAngle\Marshaller\Test\Functional\Json;

use OneMoreAngle\Marshaller\Api\Json;
use OneMoreAngle\Marshaller\Test\Fixtures\Order;
use PHPUnit\Framework\TestCase;

class SerializeJsonTest extends TestCase {

    public function testSimpleArray() {
        $data = [
            'agreement' => false,
            'properties' => [
                'clientId' => 10,
                'clientName' => 'John Doe',
                'clientEmail' => null,
            ],
            'nicknames' => [
                'John',
                'Doe',
                'JD',
            ],
            'null' => null,
        ];

        $json = Json::marshal($data);

        $this->assertEquals(json_encode($data), $json);
    }

    public function testStdObject() {
        $data = new \stdClass();
        $data->agreement = false;
        $data->properties = new \stdClass();
        $data->properties->clientId = 10;
        $data->properties->clientName = 'John Doe';
        $data->properties->clientEmail = null;
        $data->nicknames = [
            'John',
            'Doe',
            'JD',
        ];
        $data->null = null;

        $json = Json::marshal($data);
        $this->assertEquals(json_encode($data), $json);
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

        $json = Json::marshal($data);
        $this->assertEquals(json_encode($compare), $json);
    }
}