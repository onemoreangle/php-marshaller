<?php

namespace OneMoreAngle\Marshaller\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Aliases {
    /**
     * @var string[]
     */
    public array $names;

    /**
     * @param array{'value': ?string[], 'names': ?string[]} $values
     */
    public function __construct(array $values) {
        $this->names = $values['value'] ?? $values['names'] ?? [];
    }
}