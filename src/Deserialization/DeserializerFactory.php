<?php

namespace OneMoreAngle\Marshaller\Deserialization;

use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use OneMoreAngle\Marshaller\Typing\TypeToken;

class DeserializerFactory {
    protected PropertyMetadataProvider $propertyMetadataProvider;

    public function __construct(PropertyMetadataProvider $propertyMetadataProvider) {
        $this->propertyMetadataProvider = $propertyMetadataProvider;
    }

    public function create(TypeToken $typeToken) : Deserializer {
        return $typeToken->getDeserializer($this);
    }

    public function createPrimitiveDeserializer() : Deserializer {
        return new PrimitiveDeserializer();
    }

    public function createClassDeserializer(string $class) : Deserializer {
        return new ObjectDeserializer($class, $this->propertyMetadataProvider, $this);
    }

    public function createArrayDeserializer() : Deserializer {
        return new ArrayDeserializer($this);
    }
}