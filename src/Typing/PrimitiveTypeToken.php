<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Deserialization\Deserializer;
use OneMoreAngle\Marshaller\Deserialization\DeserializerFactory;
use OneMoreAngle\Marshaller\Serialization\SerializationManager;
use OneMoreAngle\Marshaller\Serialization\Serializer;

class PrimitiveTypeToken extends TypeToken {

    protected static array $instanceCache = [];

    public static function create(string $type): PrimitiveTypeToken {
        if (!isset(static::$instanceCache[$type])) {
            static::$instanceCache[$type] = new PrimitiveTypeToken($type);
        }

        return static::$instanceCache[$type];
    }

    protected function __construct($type) {
        parent::__construct($type);
    }

    public function getSerializer(SerializationManager $factory): Serializer {
        return $factory->getPrimitiveSerializer();
    }

    public function getDeserializer(DeserializerFactory $factory): Deserializer {
        return $factory->createPrimitiveDeserializer();
    }

    public function key(): string {
        return $this->type;
    }
}