<?php

namespace OneMoreAngle\Marshaller\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class OmitEmpty {
    public bool $omit;

    public function __construct(bool $omit) {
        $this->omit = $omit;
    }
}