<?php

namespace OneMoreAngle\Marshaller\Attribute\Xml;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("CLASS")
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class XmlRoot {
    public string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }
}