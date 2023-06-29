<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Aliases {
    public array $names;

    public function __construct(array $values) {
        $this->names = $values['value'] ?? $values['names'];
    }
}