<?php

namespace OneMoreAngle\Marshaller\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class TargetType {
    public string $type;

    public function __construct(string $type) {
        $this->type = $type;
    }
}