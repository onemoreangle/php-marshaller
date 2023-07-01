<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class OmitEmpty {
    public ?bool $omit;

    /**
     * @param array{'value': ?bool, 'omit': ?bool} $values
     */
    public function __construct(array $values) {
        $this->omit = $values['value'] ?? $values['omit'] ?? null;
    }
}