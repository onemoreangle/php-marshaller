<?php

namespace OneMoreAngle\Marshaller\Data;

class IntermediaryData {
    protected $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }
}