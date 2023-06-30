<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Deserialization\Deserializer;
use OneMoreAngle\Marshaller\Deserialization\DeserializerFactory;
use OneMoreAngle\Marshaller\Serialization\Serializer;
use OneMoreAngle\Marshaller\Serialization\SerializerFactory;

class ArrayTypeToken extends TypeToken {

    public function __construct() {
        parent::__construct(static::ARRAY);
    }

    public function getSerializer(SerializerFactory $factory): Serializer {
        return $factory->createArraySerializer($this);
    }

    public function getDeserializer(DeserializerFactory $factory): Deserializer {
        return $factory->createArrayDeserializer();
    }
}