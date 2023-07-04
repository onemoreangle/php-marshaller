<?php

namespace OneMoreAngle\Marshaller\Attribute\Xml;

use Attribute;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("CLASS")
 */
#[Attribute(Attribute::TARGET_CLASS)]
class XmlRoot {
    public string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }
}