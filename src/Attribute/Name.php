<?php

namespace OneMoreAngle\Marshaller\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Name {
    public string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }
}