<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class TargetClass {
    public ?string $class;

    /**
     * @param array{'value': ?string, 'class': ?string} $values
     */
    public function __construct(array $values) {
        $this->class = $values['value'] ?? $values['class'] ?? null;
    }
}