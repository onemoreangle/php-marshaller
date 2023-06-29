<?php

namespace OneMoreAngle\Marshaller\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class TargetClass {
    public string $class;

    public function __construct(string $class) {
        $this->class = $class;
    }
}