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

    /**
     * @param string[] $names
     */
    public function __construct(array $names) {
        $this->names = $names;
    }
}