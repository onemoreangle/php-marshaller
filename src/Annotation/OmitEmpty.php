<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class OmitEmpty {
    private bool $omit;

    public function __construct(array $values) {
        $this->omit = $values['value'] ?? $values['omit'];
    }
}