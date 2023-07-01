<?php

namespace OneMoreAngle\Marshaller\Attribute;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("PROPERTY")
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Aliases {
    /**
     * @var string[]
     */
    public array $names;

    public function __construct(string ...$names) {
        $this->names = $names;
    }
}