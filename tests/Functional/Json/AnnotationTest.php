<?php

namespace OneMoreAngle\Marshaller\Test\Functional\Json;

use OneMoreAngle\Marshaller\Api\Json;
use OneMoreAngle\Marshaller\Test\Fixtures\AnnotatedOmitPropOrder;
use OneMoreAngle\Marshaller\Test\Fixtures\AnnotatedOrder;
use PHPUnit\Framework\TestCase;

class AnnotationTest extends TestCase {

    public function testSimpleSerialization() {
        $json = Json::marshal($this->annotatedOrder());

        $arr = [
            'orderId' => 10,
            'orderName' => 'John Doe',
            'orderPrice' => 100.0,
            'orderPaid' => false,
            'orderDescription' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.',
        ];

        $this->assertEquals(json_encode($arr), $json);
    }

    public function testSimpleDeserialization() {
        $json = '{"orderId": 10, "orderName": "John Doe", "orderPrice": 100.0, "orderPaid": false, "orderDescription": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris."}';
        $object = Json::unmarshal($json, AnnotatedOrder::class);

        $this->assertObjectEquals($this->annotatedOrder(), $object);
    }

    public function testOmitAnnotation() {
        $annotatedOrder = $this->annotatedOmitOrderWithName('John Doe');
        $json = Json::marshal($annotatedOrder);

        // Expect the 'description' to be omitted
        $expectedArray = [
            'orderId' => 10,
            'orderName' => 'John Doe',
            'orderPrice' => 100.0,
            'orderPaid' => false,
        ];

        $this->assertEquals(json_encode($expectedArray), $json);
    }

    public function testOmitEmptyAnnotation() {
        $annotatedOrder = $this->annotatedOmitOrderWithName('');
        $json = Json::marshal($annotatedOrder);

        $expectedArray = [
            'orderId' => 10,
            'orderPrice' => 100.0,
            'orderPaid' => false,
        ];

        $this->assertEquals(json_encode($expectedArray), $json);
    }

    public function annotatedOrder() {
        $annotatedOrder = new AnnotatedOrder();
        $annotatedOrder->setId(10);
        $annotatedOrder->setName('John Doe');
        $annotatedOrder->setPrice(100.0);
        $annotatedOrder->setPaid(false);
        $annotatedOrder->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.');
        return $annotatedOrder;
    }

    public function annotatedOmitOrderWithName($name) {
        $annotatedOrder = new AnnotatedOmitPropOrder();
        $annotatedOrder->setId(10);
        // Set the 'name' to an empty string so it will be omitted
        $annotatedOrder->setName($name);
        $annotatedOrder->setPrice(100.0);
        $annotatedOrder->setPaid(false);
        $annotatedOrder->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.');
        return $annotatedOrder;
    }
}