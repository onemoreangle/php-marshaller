<?php

namespace OneMoreAngle\Marshaller\Pipeline;

/**
 * @template T
 */
class Data {
    /**
     * @var T
     */
    protected $value;

    /**
     * @param T $value
     */
    public function __construct($value) {
        $this->value = $value;
    }

    /**
     * @return T
     */
    public function getValue() {
        return $this->value;
    }
}