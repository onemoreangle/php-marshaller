<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Deserialization\Deserializer;
use OneMoreAngle\Marshaller\Deserialization\DeserializerFactory;
use OneMoreAngle\Marshaller\Serialization\SerializationManager;
use OneMoreAngle\Marshaller\Serialization\Serializer;
use OneMoreAngle\Marshaller\Serialization\Marshaller;

class ArrayTypeToken extends TypeToken {

    protected static ArrayTypeToken $instance;

    protected function __construct() {
        parent::__construct(static::ARRAY);
    }

    public static function create(): ArrayTypeToken {
        if (!isset(static::$instance)) {
            static::$instance = new ArrayTypeToken();
        }

        return static::$instance;
    }

    public function getSerializer(SerializationManager $factory): Serializer {
        return $factory->getArraySerializer($this);
    }

    public function getDeserializer(DeserializerFactory $factory): Deserializer {
        return $factory->createArrayDeserializer();
    }

    public function key(): string {
        return static::ARRAY;
    }
}