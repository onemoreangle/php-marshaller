<?php

namespace OneMoreAngle\Marshaller\Serialization;

use OneMoreAngle\Marshaller\Typing\ArrayTypeToken;
use OneMoreAngle\Marshaller\Typing\TypeToken;

class SerializationManager {
    private Marshaller $marshaller;

    public function __construct() {
        $this->marshaller = new Marshaller($this);
    }

    public function create(TypeToken $typeToken) : Serializer {
        return $typeToken->getSerializer($this);
    }

    public function getPrimitiveSerializer() : Serializer {
        return new PrimitiveSerializer();
    }

    public function getClassSerializer(string $class) : Serializer {
        return new ObjectSerializer($this->marshaller, $class);
    }

    public function getArraySerializer(ArrayTypeToken $elementType) : Serializer {
        return new ArraySerializer();
    }
}