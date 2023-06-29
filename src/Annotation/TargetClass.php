<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class TargetClass {
    public array $class;

    public function __construct(array $values) {
        $this->class = $values['value'] ?? $values['class'];
    }
}