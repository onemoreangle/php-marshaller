<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Name {
    public ?string $name = null;

    /**
     * @param array{'value': ?string, 'name': ?string} $values
     */
    public function __construct(array $values) {
        $this->name = $values['value'] ?? $values['name'] ?? null;
    }
}