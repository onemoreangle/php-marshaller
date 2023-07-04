<?php

namespace OneMoreAngle\Marshaller\Attribute;

use Attribute;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("PROPERTY")
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class TargetType {
    public string $type;

    public function __construct(string $type) {
        $this->type = $type;
    }
}