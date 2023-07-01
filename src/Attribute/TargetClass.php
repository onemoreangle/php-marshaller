<?php

namespace OneMoreAngle\Marshaller\Attribute;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("PROPERTY")
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class TargetClass {
    public string $class;

    public function __construct(string $class) {
        $this->class = $class;
    }
}