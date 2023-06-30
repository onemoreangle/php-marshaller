<?php

namespace OneMoreAngle\Marshaller\Serialization;

use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use OneMoreAngle\Marshaller\Typing\ArrayTypeToken;
use OneMoreAngle\Marshaller\Typing\TypeToken;

class SerializerFactory {
    private PropertyMetadataProvider $metadataProvider;

    public function __construct(PropertyMetadataProvider $metadataProvider) {
        $this->metadataProvider = $metadataProvider;
    }

    public function create(TypeToken $typeToken) : Serializer {
        return $typeToken->getSerializer($this);
    }

    public function createPrimitiveSerializer() : Serializer {
        return new PrimitiveSerializer();
    }

    public function createClassSerializer(string $class) : Serializer {
        return new ObjectSerializer($this->metadataProvider, $this, $class);
    }

    public function createArraySerializer(ArrayTypeToken $elementType) : Serializer {
        return new ArraySerializer($this, $elementType);
    }
}