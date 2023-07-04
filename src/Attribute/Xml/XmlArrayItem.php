<?php

namespace OneMoreAngle\Marshaller\Attribute\Xml;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("PROPERTY")
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class XmlArrayItem {
    public string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }
}