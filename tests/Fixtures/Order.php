<?php

namespace OneMoreAngle\Marshaller\Test\Fixtures;

class Order {
    private int $id;
    private string $name;
    private float $price;
    private bool $isPaid;
    private ?string $description = null;
}