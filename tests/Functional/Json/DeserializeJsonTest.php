<?php

namespace OneMoreAngle\Marshaller\Test\Functional\Json;

use OneMoreAngle\Marshaller\Api\Json;
use OneMoreAngle\Marshaller\Test\Fixtures\Order;
use OneMoreAngle\Marshaller\Test\Fixtures\OrderList;
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

    public function testArrayObject() {
        $order1 = new Order();
        $order1->setId(10);
        $order1->setName('John Doe');
        $order1->setPrice(100.0);
        $order1->setPaid(false);
        $order1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.');
        $order2 = new Order();
        $order2->setId(20);
        $order2->setName('Jane Doe');
        $order2->setPrice(200.0);
        $order2->setPaid(true);
        $order2->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.');

        $list = new OrderList();
        $list->setId(15153);
        $list->setOrders([
            $order1,
            $order2,
        ]);
        $list->setMainOrder($order1);
        $list->setStatus('in_progress');

        $compare = [
            'id' => 15153,
            'orders' => [
                [
                    'id' => 10,
                    'name' => 'John Doe',
                    'price' => 100.0,
                    'paid' => false,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.',
                ],
                [
                    'id' => 20,
                    'name' => 'Jane Doe',
                    'price' => 200.0,
                    'paid' => true,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.',
                ],
            ],
            'mainOrder' => [
                'id' => 10,
                'name' => 'John Doe',
                'price' => 100.0,
                'paid' => false,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris.',
            ],
            'status' => 'in_progress',
        ];

        $raw = json_encode($compare);
        $object = Json::unmarshal($raw, OrderList::class);
        $this->assertObjectEquals($list, $object);
    }
}