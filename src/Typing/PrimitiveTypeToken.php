<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Deserialization\Deserializer;
use OneMoreAngle\Marshaller\Deserialization\DeserializerFactory;
use OneMoreAngle\Marshaller\Serialization\Serializer;
use OneMoreAngle\Marshaller\Serialization\SerializerFactory;

class PrimitiveTypeToken extends TypeToken {

    public function __construct($type) {
        parent::__construct($type);
    }

    public function getSerializer(SerializerFactory $factory): Serializer {
        return $factory->createPrimitiveSerializer();
    }

    public function getDeserializer(DeserializerFactory $factory): Deserializer {
        return $factory->createPrimitiveDeserializer();
    }
}