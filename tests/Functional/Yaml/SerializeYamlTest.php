<?php

namespace OneMoreAngle\Marshaller\Test\Functional\Yaml;

use OneMoreAngle\Marshaller\Api\Yaml;
use OneMoreAngle\Marshaller\Test\Fixtures\Order;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class SerializeYamlTest extends TestCase {

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

        $yaml = Yaml::marshal($data);
        $this->assertEquals(SymfonyYaml::dump($data), $yaml);
    }

    private function objectToArray($object) {
        if (is_object($object)) {
            $object = get_object_vars($object);
        }

        if (is_array($object)) {
            return array_map([$this, 'objectToArray'], $object);
        }

        return $object;
    }

    public function testStdObject() {
        $data = new stdClass();
        $data->agreement = false;
        $data->properties = new stdClass();
        $data->properties->clientId = 10;
        $data->properties->clientName = 'John Doe';
        $data->properties->clientEmail = null;
        $data->nicknames = [
            'John',
            'Doe',
            'JD',
        ];
        $data->null = null;

        $yaml = Yaml::marshal($data);
        $this->assertEquals(SymfonyYaml::dump($this->objectToArray($data)), $yaml);
    }

    public function testSimpleObject() {
        $compare = [
            'id' => 10,
            'name' => 'John Doe',
            'price' => 100.0,
            'paid' => false,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.',
        ];

        $data = new Order();
        $data->setId($compare['id']);
        $data->setName($compare['name']);
        $data->setPrice($compare['price']);
        $data->setPaid($compare['paid']);
        $data->setDescription($compare['description']);

        $yaml = Yaml::marshal($data);
        $this->assertEquals(SymfonyYaml::dump($compare), $yaml);
    }
}