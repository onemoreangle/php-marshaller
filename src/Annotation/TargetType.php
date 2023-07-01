<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class TargetType {
    public ?string $type;

    /**
     * @param array{'value': ?string, 'type': ?string} $values
     */
    public function __construct(array $values) {
        $this->type = $values['value'] ?? $values['type'] ?? null;
    }
}