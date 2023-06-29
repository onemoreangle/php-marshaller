<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Name {
    public string $name;

    public function __construct(array $values) {
        $this->name = $values['value'] ?? $values['name'];
    }
}