<?php

namespace OneMoreAngle\Marshaller\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Aliases {
    public array $names;

    public function __construct(string ...$names) {
        $this->names = $names;
    }
}