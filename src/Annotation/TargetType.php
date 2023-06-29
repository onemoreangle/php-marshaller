<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class TargetType {
    public array $type;

    public function __construct(array $values) {
        $this->type = $values['value'] ?? $values['type'];
    }
}