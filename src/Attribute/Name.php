<?php

namespace OneMoreAngle\Marshaller\Attribute;

use Attribute;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("PROPERTY")
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Name {
    public string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }
}